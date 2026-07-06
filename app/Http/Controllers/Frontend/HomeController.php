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
        $services = Service::where('is_active', true)->get();
        $destinations = Destination::where('is_active', true)->get()->groupBy('category');
        $activeCategories = DestinationCategory::where('is_active', true)->get();
        $activeSlugs = $activeCategories->pluck('slug')->toArray();
        $destinations = collect($activeSlugs)->mapWithKeys(function ($slug) use ($destinations) {
            return [$slug => $destinations->get($slug, collect())];
        })->filter()->all();
        $packages = TourPackage::where('is_active', true)->latest()->take(4)->get();
        $testimonials = Testimonial::where('is_active', true)->latest()->take(6)->get();
        return view('home', compact('services', 'destinations', 'packages', 'testimonials', 'activeCategories'));
    }

    public function cars()
    {
        $services = Service::where('is_active', true)->get();
        $cars = Car::where('is_active', true)->paginate(12);
        return view('cars', compact('cars', 'services'));
    }

    public function packages()
    {
        $packages = TourPackage::where('is_active', true)->paginate(12);
        return view('packages', compact('packages'));
    }

    public function carDetail($id)
    {
        $car = Car::findOrFail($id);
        $services = Service::where('is_active', true)->get();
        return view('car-detail', compact('car', 'services'));
    }

    public function packageDetail($slug)
    {
        $package = TourPackage::where('slug', $slug)->with('destinations')->firstOrFail();
        return view('package-detail', compact('package'));
    }

    public function destinationDetail($slug)
    {
        $destination = Destination::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('destination-detail', compact('destination'));
    }

    public function destinationsByCategory($category)
    {
        $destinations = Destination::where('category', $category)->where('is_active', true)->paginate(12);
        return view('destinations', compact('destinations', 'category'));
    }
}
