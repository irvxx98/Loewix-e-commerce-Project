<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutorial;
use App\Models\User;
use App\Enums\Role;

class SupportController extends Controller
{
    public function index()
    {
        return view('support.index');
    }

    public function tutorials()
    {
        $tutorials = Tutorial::all()->groupBy('category');
        return view('support.tutorials', compact('tutorials'));
    }

    public function dealers()
    {
        $dealers = User::where('role', Role::DEALER)->with('dealerProfile')->get();
        return view('support.dealers', compact('dealers'));
    }

    public function faq()
    {
        $faqs = [
            'Umum' => [
                'Siapa itu Loewix?' => 'Loewix adalah merek terkemuka dalam industri keamanan yang berfokus pada penyediaan produk CCTV, NVR, DVR, dan aksesoris berkualitas tinggi untuk kebutuhan residensial maupun komersial di seluruh Indonesia.',
                'Bagaimana cara menjadi dealer resmi?' => 'Anda dapat menghubungi tim sales kami melalui WhatsApp atau email yang tertera di halaman kontak untuk informasi lengkap mengenai syarat dan keuntungan program kemitraan dealer.',
                'Di mana lokasi fisik Loewix?' => 'Kantor pusat dan gudang kami berlokasi di Semarang, Jawa Tengah. Namun, produk kami didistribusikan melalui jaringan dealer resmi yang tersebar di berbagai kota.'
            ],
            'Produk & Garansi' => [
                'Apakah semua produk Loewix bergaransi?' => 'Ya, semua produk utama kami seperti kamera, DVR, dan NVR memiliki garansi resmi selama 1 hingga 2 tahun. Aksesoris seperti kabel dan adaptor memiliki ketentuan garansi yang berbeda. Silakan cek halaman produk untuk detail spesifik.',
                'Apa perbedaan antara kamera AHD dan IP?' => 'Kamera AHD (Analog High Definition) menggunakan kabel coaxial dan terhubung ke DVR. Kamera IP (Internet Protocol) menggunakan kabel LAN dan terhubung ke NVR. Kamera IP umumnya menawarkan resolusi lebih tinggi dan fitur yang lebih canggih.',
                'Bagaimana cara klaim garansi?' => 'Untuk klaim garansi, Anda dapat menghubungi dealer tempat Anda membeli produk atau langsung menghubungi tim Customer Service kami dengan menyertakan bukti pembelian.'
            ],
            'Pesanan & Pengiriman' => [
                'Berapa lama proses pengiriman pesanan?' => 'Pesanan yang ditangani oleh dealer akan diproses sesuai dengan kebijakan toko masing-masing. Pesanan yang ditangani oleh pusat Loewix akan dikirim dalam 1-2 hari kerja setelah pembayaran dikonfirmasi.',
                'Apakah saya bisa membatalkan pesanan?' => 'Anda bisa membatalkan pesanan selama statusnya masih "Pending Dealer Acceptance" atau "Pending Payment". Pesanan yang sudah masuk tahap "Processing" tidak dapat dibatalkan.',
                'Bagaimana cara melacak pesanan saya?' => 'Anda dapat melihat status terakhir pesanan Anda di halaman "Riwayat Pesanan" di dalam menu akun Anda.'
            ],
            'Teknis & Aplikasi' => [
                'Aplikasi apa yang digunakan untuk CCTV Loewix?' => 'Kami menggunakan aplikasi XMEye Pro yang tersedia secara gratis di Google Play Store (Android) dan Apple App Store (iOS) untuk pemantauan jarak jauh.',
                'Mengapa kamera saya offline di aplikasi?' => 'Pastikan NVR/DVR Anda terhubung dengan benar ke router internet dan tidak ada masalah pada koneksi jaringan Anda. Anda juga bisa memeriksa panduan troubleshooting kami atau menghubungi tim technical support.',
                'Berapa kapasitas hardisk maksimal yang didukung?' => 'Kapasitas maksimal bervariasi tergantung model NVR/DVR. Sebagian besar model terbaru kami mendukung hardisk dengan kapasitas hingga 8TB atau lebih.'
            ]
        ];
        return view('support.faq', compact('faqs'));
    }

    public function contact()
    {
        return view('support.contact');
    }

    public function sendContactMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        \App\Models\ContactMessage::create($validated);

        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim.');
    }
}
