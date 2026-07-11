<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Destination;
use App\Models\DestinationCategory;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\TourPackage;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::active()->get();
        $destinations = Destination::active()->get()->groupBy('category');
        $activeCategories = DestinationCategory::active()->get();
        $categoryLabels = $activeCategories->pluck('name', 'slug')->toArray();
        $activeSlugs = $activeCategories->pluck('slug')->toArray();
        $destinations = collect($activeSlugs)->mapWithKeys(function ($slug) use ($destinations) {
            return [$slug => $destinations->get($slug, collect())];
        })->filter()->all();
        $packages = TourPackage::active()->latest()->take(4)->get();
        $testimonials = Testimonial::active()->latest()->take(6)->get();
        return view('home', compact('services', 'destinations', 'packages', 'testimonials', 'activeCategories', 'categoryLabels'));
    }

    public function cars()
    {
        $cars = Car::active()->paginate(12);
        return view('cars', compact('cars'));
    }

    public function packages()
    {
        $packages = TourPackage::active()->paginate(12);
        return view('packages', compact('packages'));
    }

    public function carDetail($id)
    {
        $car = Car::findOrFail($id);
        return view('car-detail', compact('car'));
    }

    public function packageDetail($slug)
    {
        $package = TourPackage::where('slug', $slug)->with('destinations')->firstOrFail();
        return view('package-detail', compact('package'));
    }

    public function destinationDetail($slug)
    {
        $destination = Destination::where('slug', $slug)->active()->firstOrFail();
        return view('destination-detail', compact('destination'));
    }

    public function destinationsByCategory($category)
    {
        $destinations = Destination::where('category', $category)->active()->paginate(12);
        return view('destinations', compact('destinations', 'category'));
    }
}
