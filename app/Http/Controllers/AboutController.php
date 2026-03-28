<?php

namespace App\Http\Controllers;

use App\Models\AboutSetting;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Get the first (and should be only) about settings record
        $aboutSetting = AboutSetting::first();
        
        // If no settings exist, create default data
        if (!$aboutSetting) {
            $aboutSetting = new AboutSetting([
                'title' => 'Tentang Sulthan Property',
                'description' => '<p>Sulthan Property adalah perusahaan pengembang properti yang berfokus pada penyediaan perumahan berkualitas dengan harga terjangkau.</p>',
                'vision' => '<p>Menjadi pengembang properti terpercaya yang menghadirkan hunian berkualitas dan terjangkau untuk seluruh masyarakat Indonesia.</p>',
                'mission' => '<ul><li>Mengembangkan perumahan dengan lokasi strategis dan fasilitas lengkap</li><li>Memberikan kualitas bangunan terbaik dengan harga yang kompetitif</li><li>Menyediakan layanan pelanggan yang profesional dan responsif</li><li>Menciptakan lingkungan hunian yang nyaman dan berkelanjutan</li></ul>',
                'why_choose_us' => [
                    ['icon' => 'check-circle', 'title' => 'Terpercaya', 'description' => 'Pengalaman bertahun-tahun di industri properti'],
                    ['icon' => 'map-pin', 'title' => 'Lokasi Strategis', 'description' => 'Dekat dengan fasilitas umum dan pusat kota'],
                    ['icon' => 'currency-dollar', 'title' => 'Harga Terjangkau', 'description' => 'Skema pembayaran yang fleksibel'],
                    ['icon' => 'bolt', 'title' => 'Kualitas Terbaik', 'description' => 'Material berkualitas dan konstruksi kokoh'],
                ],
            ]);
        }
        
        return view('about', compact('aboutSetting'));
    }
}
