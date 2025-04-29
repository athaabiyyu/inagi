<?php
/*
Template Name: home-custom
*/

// Panggil semua produk dari file eksternal
include 'produk-data.php';

// Filter produk berdasarkan kategori
$MilktechMachines = array_filter($AllMachines, fn($item) => in_array($item['id'], [19, 20, 21, 22, 23]));
$MilktechMachines = array_values($MilktechMachines);

$RetortMachines = array_filter($AllMachines, fn($item) => in_array($item['id'], [1, 24, 25, 26, 27]));
$RetortMachines = array_values($RetortMachines);

// Tambahkan kategori lain kalau dibutuhkan
?>


<!DOCTYPE html>
<html lang="en">
<head>
<!--Final HEAD yang dijamin aman dan icon tampil -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jualmesin.co.id - Produsen Mesin Retort</title>

<!-- Framework & Fonts -->
<script src="https://cdn.gpteng.co/gptengineer.js" type="module"></script>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="https://jualmesin.co.id/wp-content/uploads/2025/04/Jualmesin-e1745594520519.png">

<!--Lucide versi auto-render, cukup 1 ini aja -->
<script src="https://unpkg.com/lucide@latest"></script>


    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .carousel-item {
            flex: 0 0 100%;
            scroll-snap-align: start;
        }
        
        .carousel-container {
            scroll-snap-type: x mandatory;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .carousel-container::-webkit-scrollbar {
            display: none;
        }
        
        @media (min-width: 768px) {
            .carousel-item {
                flex: 0 0 50%;
            }
        }
        
        @media (min-width: 1024px) {
            .carousel-item {
                flex: 0 0 33.333%;
            }
        }
        
        @media (min-width: 1280px) {
            .carousel-item {
                flex: 0 0 25%;
            }
        }
        
        /* Tambahan styling khusus untuk All Machine cards */
		.all-machine-grid {
		  display: grid;
		  grid-template-columns: repeat(2, 1fr);
		  gap: 12px;
		  padding: 8px;
		}

		@media (min-width: 768px) {
		  .all-machine-grid {
			grid-template-columns: repeat(3, 1fr);
		  }
		}

		@media (min-width: 1024px) {
		  .all-machine-grid {
			grid-template-columns: repeat(4, 1fr);
		  }
		}

		.all-machine-card {
		  background: #fff;
		  border-radius: 8px;
		  overflow: hidden;
		  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
		  transition: box-shadow 0.3s ease;
		  display: flex;
		  flex-direction: column;
		}

		.all-machine-card:hover {
		  box-shadow: 0 4px 12px rgba(0,0,0,0.12);
		}

		.all-machine-card img {
		  width: 100%;
		  aspect-ratio: 1 / 1;
		  object-fit: cover;
		  border-bottom: 1px solid #f3f4f6;
		}

		.all-machine-card .product-title {
		  font-size: 13px;
		  font-weight: 600;
		  color: #111827;
		  margin-top: 8px;
		  padding: 0 8px;
		  line-height: 1.3;
		  -webkit-line-clamp: 2;
		  display: -webkit-box;
		  -webkit-box-orient: vertical;
		  overflow: hidden;
		}

		.all-machine-card .product-description {
		  font-size: 11px;
		  color: #6b7280;
		  margin-top: 4px;
		  padding: 0 8px;
		  line-height: 1.4;
		  -webkit-line-clamp: 2;
		  display: -webkit-box;
		  -webkit-box-orient: vertical;
		  overflow: hidden;
		  margin-bottom: 12px;
		}

		/* Tombol Group */
		.all-machine-card .btn-group {
		  display: flex;
		  align-items: center;
		  padding: 0 8px 12px;
		  gap: 10px;
		}

		/* Tombol Chat Icon */
		.all-machine-card .btn-chat-icon {
		  width: 22%;
		  min-width: 44px;
		  max-width: 60px;
		  background-color: #22c55e;
		  color: #fff;
		  display: flex;
		  align-items: center;
		  justify-content: center;
		  padding: 10px;
		  border-radius: 6px;
		  transition: background-color 0.3s ease;
		}

		.all-machine-card .btn-chat-icon:hover {
		  background-color: #16a34a;
		}

		/* Tombol Detail */
		.all-machine-card .btn-detail {
		  flex: 1;
		  background-color: #fff;
		  color: #111827;
		  text-align: center;
		  padding: 10px 0;
		  font-size: 13px;
		  font-weight: 600;
		  border: 1px solid #111827;
		  border-radius: 6px;
		  transition: all 0.3s ease;
		}

		.all-machine-card .btn-detail:hover {
		  background-color: #f97316;
		  color: #fff;
		  border-color: #f97316;
		}


        /*Style Untuk News*/
        #post-carousel::-webkit-scrollbar {
            display: none;
        }
        .carousel-item {
            flex: 0 0 auto;
        }
        .carousel-container {
            scroll-snap-type: x mandatory;
        }
        .carousel-item {
            scroll-snap-align: start;
        }
        .carousel-item img {
            aspect-ratio: 1 / 1; /* ✅ 1:1 ratio for square images */
            object-fit: cover;
        }        
    </style>
</head>
<body class="bg-white text-black">
    <!-- Header/Navbar -->
    <header class="sticky top-0 w-full bg-white shadow-md z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                <a href="#" class="flex items-center">
                <img src="https://jualmesin.co.id/wp-content/uploads/2025/04/Logo-Jualmesin.co_.id_.png" alt="Jual Mesin Murah" class="h-12 sm:h-14 md:h-16 w-auto">
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#" class="font-medium text-gray-900 hover:text-amber-600 transition-colors">Home</a>
                    <a href="#" class="font-medium text-gray-700 hover:text-amber-600 transition-colors">Katalog</a>
                    <a href="#" class="font-medium text-gray-700 hover:text-amber-600 transition-colors">Mesin Retort</a>
                    <a href="#" class="font-medium text-gray-700 hover:text-amber-600 transition-colors">Eksplorasi</a>
                    <a href="#projects" class="font-medium text-gray-700 hover:text-amber-600 transition-colors">Projek</a>
                    <a href="#news" class="font-medium text-gray-700 hover:text-amber-600 transition-colors">Artikel</a>
                </nav>
                
                <!-- Desktop Action Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <button class="p-2 rounded-full hover:bg-gray-100">
                        <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                    </button>
                    <button class="p-2 rounded-full hover:bg-gray-100">
                        <i data-lucide="user" class="w-6 h-6"></i>
                    </button>
                    <a id="whatsapp-button" href="#" target="_blank" class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-amber-600 transition-colors"> Konsultasi</a>
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="p-2 rounded-full hover:bg-gray-100">
                        <i data-lucide="menu" class="w-6 h-6 menu-icon"></i>
                        <i data-lucide="x" class="w-6 h-6 hidden close-icon"></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Menu Panel - Hidden by default -->
            <div id="mobile-menu" class="md:hidden hidden bg-white py-4 animate-fade-in">
                <div class="flex flex-col space-y-4 px-4">
                    <a href="#" class="font-medium text-gray-900 hover:text-amber-600 py-2 transition-colors">Home</a>
                    <a href="#products" class="font-medium text-gray-700 hover:text-amber-600 py-2 transition-colors">Products</a>
                    <a href="#about" class="font-medium text-gray-700 hover:text-amber-600 py-2 transition-colors">About Us</a>
                    <a href="#projects" class="font-medium text-gray-700 hover:text-amber-600 py-2 transition-colors">Projects</a>
                    <a href="#news" class="font-medium text-gray-700 hover:text-amber-600 py-2 transition-colors">News</a>
                    <a id="whatsapp-button-mobile" href="#" target="_blank"  class="bg-gray-900 text-white px-4 py-2 rounded text-center hover:bg-amber-600 transition-colors"> Konsultasi</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Carousel Section -->
        <section class="w-full bg-black relative overflow-hidden">
            <div class="mx-auto">
                <div class="hero-carousel relative">
                    <div class="carousel-container flex transition-transform duration-500">

                        <!-- Slide 1: Mesin Retort -->
                        <div class="carousel-item relative w-full">
                            <img src="https://plus.unsplash.com/premium_photo-1682141809453-9014014096d3?q=80&w=2072&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Produsen Mesin Retort - INAGI" class="w-full h-[320px] sm:h-[400px] md:h-[500px] lg:h-[600px] object-cover">
                            <div class="absolute inset-0 bg-black/40 flex flex-col justify-center px-6 md:px-16">
                                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                                    Produsen Mesin Retort
                                </h1>
                                <p class="text-lg md:text-xl lg:text-2xl text-white/90 max-w-2xl">
                                    Spesialis Mesin Retort dengan Inovasi dan Teknologi Terbaru untuk sterilisasi produk makanan & minuman secara efektif dan higienis.
                                </p>
                            </div>
                        </div>

                        <!-- Slide 2: Mesin Pasteurisasi Susu -->
                        <div class="carousel-item relative w-full">
                            <img src="https://plus.unsplash.com/premium_photo-1682141809453-9014014096d3?q=80&w=2072&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Mesin Pasteurisasi Susu - INAGI" class="w-full h-[320px] sm:h-[400px] md:h-[500px] lg:h-[600px] object-cover">
                            <div class="absolute inset-0 bg-black/40 flex flex-col justify-center px-6 md:px-16">
                                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                                    Mesin Pasteurisasi Susu
                                </h1>
                                <p class="text-lg md:text-xl lg:text-2xl text-white/90 max-w-2xl">
                                    Teknologi pasteurisasi untuk menjaga kualitas dan keamanan susu serta memperpanjang masa simpan produk olahan.
                                </p>
                            </div>
                        </div>

                        <!-- Slide 3: Mesin Spray Dryer -->
                        <div class="carousel-item relative w-full">
                            <img src="https://plus.unsplash.com/premium_photo-1682141809453-9014014096d3?q=80&w=2072&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Mesin Spray Dryer - INAGI" class="w-full h-[320px] sm:h-[400px] md:h-[500px] lg:h-[600px] object-cover">
                            <div class="absolute inset-0 bg-black/40 flex flex-col justify-center px-6 md:px-16">
                                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                                    Mesin Spray Dryer
                                </h1>
                                <p class="text-lg md:text-xl lg:text-2xl text-white/90 max-w-2xl">
                                    Solusi pengeringan cairan menjadi bubuk secara efisien dan cepat, cocok untuk industri makanan, susu, herbal, dan kimia.
                                </p>
                            </div>
                        </div>

                        <!-- Slide 4: Mesin Autoclave -->
                        <div class="carousel-item relative w-full">
                            <img src="https://plus.unsplash.com/premium_photo-1682141754937-14d42063d709?q=80&w=2072&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Mesin Autoclave - INAGI" class="w-full h-[320px] sm:h-[400px] md:h-[500px] lg:h-[600px] object-cover">
                            <div class="absolute inset-0 bg-black/40 flex flex-col justify-center px-6 md:px-16">
                                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                                    Mesin Autoclave
                                </h1>
                                <p class="text-lg md:text-xl lg:text-2xl text-white/90 max-w-2xl">
                                    Cocok untuk industri pengalengan, steril tulang, dan pengolahan herbal dengan sistem tekanan tinggi dan temperatur stabil.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Carousel Indicators -->
                    <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2 z-10">
                        <button class="w-2.5 h-2.5 rounded-full bg-white opacity-50 carousel-dot active"></button>
                        <button class="w-2.5 h-2.5 rounded-full bg-white opacity-50 carousel-dot"></button>
                        <button class="w-2.5 h-2.5 rounded-full bg-white opacity-50 carousel-dot"></button>
                        <button class="w-2.5 h-2.5 rounded-full bg-white opacity-50 carousel-dot"></button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Product Retort -->
        <section id="retort-products" class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="mb-10">
                <h2 class="text-2xl md:text-3xl font-bold mb-2 border-l-4 border-amber-600 pl-3">Retort Machines</h2>
                <p class="text-gray-600">Explore our specialized retort sterilizer equipment</p>
            </div>

            <div class="product-carousel relative overflow-hidden">
                <div class="carousel-container flex transition-transform duration-500 overflow-x-auto">
                <?php foreach ($RetortMachines as $product): ?>
                    <div class="carousel-item px-2 min-w-[250px] max-w-[300px]">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="w-full h-48 object-cover">
                        <div class="p-4 flex flex-col flex-1 justify-between">
                        <div>
                            <h3 class="font-bold text-lg mb-1 line-clamp-2"><?= $product['name'] ?></h3>
                            <p class="text-sm text-gray-500 line-clamp-2 mb-2"><?= $product['description'] ?></p>
                        </div>
                        <a href="<?= $product['url'] ?>" class="mt-auto w-full border border-gray-900 text-gray-900 py-2 px-4 rounded hover:bg-amber-600 hover:border-amber-600 hover:text-white transition-colors duration-300 block text-center">
                            Details
                        </a>
                        </div>
                    </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </section>
        
        <!-- Product Milktech -->
        <section id="milktech-products" class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="mb-10">
                <h2 class="text-2xl md:text-3xl font-bold mb-2 border-l-4 border-amber-600 pl-3">Milktech Machines</h2>
                <p class="text-gray-600">Explore our high-performance milk and pasteurization equipment</p>
            </div>

            <div class="product-carousel relative overflow-hidden">
                <div class="carousel-container flex transition-transform duration-500 overflow-x-auto">
                <?php foreach ($MilktechMachines as $product): ?>
                    <div class="carousel-item px-2 min-w-[250px] max-w-[300px]">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="w-full h-48 object-cover">
                        <div class="p-4 flex flex-col flex-1 justify-between">
                        <div>
                            <h3 class="font-bold text-lg mb-1 line-clamp-2"><?= $product['name'] ?></h3>
                            <p class="text-sm text-gray-500 line-clamp-2 mb-2"><?= $product['description'] ?></p>
                        </div>
                        <a href="<?= $product['url'] ?>" class="mt-auto w-full border border-gray-900 text-gray-900 py-2 px-4 rounded hover:bg-amber-600 hover:border-amber-600 hover:text-white transition-colors duration-300 block text-center">
                            Details
                        </a>
                        </div>
                    </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Promo Banner Section -->
        <section class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="flex-1 relative overflow-hidden rounded-lg shadow-md">
                        <img src="https://inagi.co.id/wp-content/uploads/2025/02/Picture2.png" alt="New Equipment" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-6">
                            <h3 class="text-white text-xl font-bold mb-2">New Equipment</h3>
                            <p class="text-white/90 mb-4">Check out our latest industrial machines</p>
                            <a href="#" class="bg-white text-gray-900 px-4 py-2 rounded inline-block hover:bg-amber-600 hover:text-white transition-colors duration-300 w-max">Explore Now</a>
                        </div>
                    </div>
                    
                    <div class="flex-1 relative overflow-hidden rounded-lg shadow-md">
                        <img src="https://inagi.co.id/wp-content/uploads/2025/02/Picture2.png" alt="Special Offers" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-6">
                            <h3 class="text-white text-xl font-bold mb-2">Special Offers</h3>
                            <p class="text-white/90 mb-4">Limited time discounts on premium products</p>
                            <a href="#" class="bg-white text-gray-900 px-4 py-2 rounded inline-block hover:bg-amber-600 hover:text-white transition-colors duration-300 w-max">View Deals</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

		<!-- All Machine Section -->
		<section id="all-machines" class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
		  <div class="mb-10">
			<h2 class="text-2xl md:text-3xl font-bold mb-2 border-l-4 border-amber-600 pl-3">All Machine</h2>
			<p class="text-gray-600">Complete collection of our manufacturing equipment</p>
		  </div>

		  <div class="all-machine-grid">
			<?php foreach ($AllMachines as $product): ?>
			  <div class="all-machine-card">
				<img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">

				<div>
				  <h3 class="product-title"><?= $product['name'] ?></h3>
				  <p class="product-description"><?= $product['description'] ?></p>

				  <div class="btn-group">
					<!-- Chat Icon Button -->
					<a
					  href="https://wa.me/6281555499975?text=Halo%20INAGI,%20saya%20ingin%20konsultasi%20tentang%20produk:%20<?= urlencode($product['name']) ?>"
					  target="_blank"
					  rel="noopener noreferrer"
					  class="btn-chat-icon"
					>
					  <i data-lucide="message-circle" class="w-5 h-5"></i>
					</a>

					<!-- Detail Button -->
					<a
					  href="product-detail.php?id=<?= $product['id'] ?>"
					  class="btn-detail"
					>
					  Detail
					</a>
				  </div>
				</div>
			  </div>
			<?php endforeach; ?>
		  </div>
		</section>






        <!-- Tentang Kami -->
        <section id="about" class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row gap-10 items-center">
                <div class="md:w-1/2">
                <h2 class="text-2xl md:text-3xl font-bold mb-6 border-l-4 border-amber-600 pl-3">Tentang Jual Mesin </h2>
                <p class="text-gray-700 mb-4 font-medium italic">
                    Manufacturing innovative and automatic machine
                </p>
                <p class="text-gray-700 mb-4">
                    INAGI adalah perusahaan teknologi manufaktur mesin yang melayani kebutuhan UMKM hingga industri menengah. Kami fokus pada pengembangan mesin proses termal di bidang makanan, minuman, dan agroindustri.
                </p>
                <p class="text-gray-700 mb-4">
                    Kami juga menerima pesanan mesin secara <strong>custom</strong> sesuai dengan kebutuhan dan budget pelanggan. Didukung tim teknis berpengalaman, kami menjamin kualitas dan layanan purna jual terbaik.
                </p>
                <p class="text-gray-700 mb-6">
                    INAGI terbuka untuk kolaborasi bersama instansi pemerintah, BUMN, maupun swasta, serta kemitraan dalam proses perizinan dan ekspor-impor.
                </p>
                <a href="#contact" class="bg-gray-900 text-white px-6 py-3 rounded inline-block hover:bg-amber-600 transition-colors duration-300">Hubungi Kami</a>
                </div>
                <div class="md:w-1/2">
                <img src="https://lh3.googleusercontent.com/p/AF1QipODV0fB45OUm7ygEw9f_QhEY3S205lo1TRoEMN-=s680-w680-h510" alt="About INAGI" class="rounded-lg shadow-lg w-full max-w-md mx-auto">
                </div>
            </div>
        </section>
        
        <!-- Kenapa Memilih INAGI -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl md:text-3xl font-bold mb-12 text-center">Kenapa Memilih Jual Mesin?</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- INOVATIF -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center text-center">
                        <div class="bg-amber-100 p-3 rounded-full mb-4">
                            <i data-lucide="lightbulb" class="w-8 h-8 text-amber-600"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">INOVATIF</h3>
                        <p class="text-gray-600">
                            Nilai utama kami adalah inovasi. Setiap mesin yang kami produksi merupakan hasil pengembangan dan penyempurnaan dari teknologi yang sudah ada, dengan desain modern dan struktur yang kokoh.
                        </p>
                    </div>

                    <!-- TERPERCAYA -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center text-center">
                        <div class="bg-amber-100 p-3 rounded-full mb-4">
                            <i data-lucide="shield-check" class="w-8 h-8 text-amber-600"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">TERPERCAYA</h3>
                        <p class="text-gray-600">
                            Kami membangun kepercayaan melalui kualitas mesin dan pelayanan kami. Kepercayaan ini tumbuh seiring pengalaman, waktu, dan konsistensi pelayanan terhadap pelanggan kami.
                        </p>
                    </div>

                    <!-- PROFESIONAL -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center text-center">
                        <div class="bg-amber-100 p-3 rounded-full mb-4">
                            <i data-lucide="briefcase" class="w-8 h-8 text-amber-600"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">PROFESIONAL</h3>
                        <p class="text-gray-600">
                            Kami menjunjung tinggi profesionalisme dalam setiap proses produksi, mulai dari waktu pengerjaan yang tepat, layanan aftersales, hingga jaminan produk yang terpercaya.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- News & Articles Section -->
        <section id="news" class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="mb-10">
                <h2 class="text-2xl md:text-3xl font-bold mb-2 border-l-4 border-amber-600 pl-3">Latest News & Articles</h2>
                <p class="text-gray-600">Stay updated with industry trends and company announcements</p>
            </div>

            <div class="news-carousel relative overflow-hidden">
                <div id="post-carousel" class="carousel-container flex gap-4 overflow-x-auto transition-transform duration-500 scroll-smooth">
                <!-- Post cards will be injected here by JavaScript -->
                </div>
            </div>
        </section>

        <!-- Projects Gallery Section -->
        <section id="projects" class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold mb-2 border-l-4 border-amber-600 pl-3">Recent Projects</h2>
                    <p class="text-gray-600">Explore our successful installations and case studies</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Project 1 -->
                    <div class="group relative overflow-hidden rounded-lg shadow-md">
                        <img src="https://images.unsplash.com/photo-1581093458791-9fc7e10b7f00?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Project 1" class="w-full h-64 object-cover transition-transform group-hover:scale-105 duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5 transform translate-y-2 group-hover:translate-y-0 transition-transform">
                            <h3 class="text-white text-xl font-bold mb-1">Food Processing Plant</h3>
                            <p class="text-white/90 mb-3">Complete installation of food processing equipment for XYZ Foods</p>
                            <a href="#" class="text-white inline-flex items-center font-medium group">
                                <span>View Case Study</span>
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Project 2 -->
                    <div class="group relative overflow-hidden rounded-lg shadow-md">
                        <img src="https://images.unsplash.com/photo-1581092787765-e691ca7d13d9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Project 2" class="w-full h-64 object-cover transition-transform group-hover:scale-105 duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5 transform translate-y-2 group-hover:translate-y-0 transition-transform">
                            <h3 class="text-white text-xl font-bold mb-1">Automotive Manufacturing</h3>
                            <p class="text-white/90 mb-3">Custom solution for ABC Motors assembly line</p>
                            <a href="#" class="text-white inline-flex items-center font-medium group">
                                <span>View Case Study</span>
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Project 3 -->
                    <div class="group relative overflow-hidden rounded-lg shadow-md">
                        <img src="https://images.unsplash.com/photo-1581093577421-f8c9a5d5c83e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Project 3" class="w-full h-64 object-cover transition-transform group-hover:scale-105 duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5 transform translate-y-2 group-hover:translate-y-0 transition-transform">
                            <h3 class="text-white text-xl font-bold mb-1">Pharmaceutical Equipment</h3>
                            <p class="text-white/90 mb-3">Specialized machinery for MNO Pharmaceuticals</p>
                            <a href="#" class="text-white inline-flex items-center font-medium group">
                                <span>View Case Study</span>
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Partners Section -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl md:text-3xl font-bold mb-10 text-center">Our Trusted Partners</h2>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-8 items-center justify-items-center">
                    <!-- Partner Logos -->
                    <div class="grayscale hover:grayscale-0 transition-all duration-300">
                        <img src="https://placehold.co/200x80?text=PARTNER+1" alt="Partner 1" class="h-10 w-auto">
                    </div>
                    <div class="grayscale hover:grayscale-0 transition-all duration-300">
                        <img src="https://placehold.co/200x80?text=PARTNER+2" alt="Partner 2" class="h-10 w-auto">
                    </div>
                    <div class="grayscale hover:grayscale-0 transition-all duration-300">
                        <img src="https://placehold.co/200x80?text=PARTNER+3" alt="Partner 3" class="h-10 w-auto">
                    </div>
                    <div class="grayscale hover:grayscale-0 transition-all duration-300">
                        <img src="https://placehold.co/200x80?text=PARTNER+4" alt="Partner 4" class="h-10 w-auto">
                    </div>
                    <div class="grayscale hover:grayscale-0 transition-all duration-300">
                        <img src="https://placehold.co/200x80?text=PARTNER+5" alt="Partner 5" class="h-10 w-auto">
                    </div>
                </div>
            </div>
        </section>

        <!-- Formulir Minta Penawaran ke WhatsApp -->
        <section id="contact" class="py-16 bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row gap-12">
                
                <!-- Info Kontak -->
                <div class="md:w-1/2">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6">Minta Penawaran</h2>
                    <p class="mb-8">Silakan isi formulir di bawah ini dan tim jual mesin akan segera menghubungi Anda melalui WhatsApp.</p>

                    <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="bg-amber-600/20 p-3 rounded-full mr-4">
                        <i data-lucide="map-pin" class="w-6 h-6 text-amber-500"></i>
                        </div>
                        <div>
                        <h3 class="font-bold text-lg mb-1">Alamat</h3>
                        <p class="text-gray-300">Jl. Manisa No.2, Bumiayu, Kedungkandang, Kota Malang, Jawa Timur 65135</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-amber-600/20 p-3 rounded-full mr-4">
                        <i data-lucide="phone" class="w-6 h-6 text-amber-500"></i>
                        </div>
                        <div>
                        <h3 class="font-bold text-lg mb-1">WhatsApp</h3>
                        <a href="https://wa.me/6281555499975" target="_blank" class="text-gray-300 hover:text-white">+62 815-5549-9975</a>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-amber-600/20 p-3 rounded-full mr-4">
                        <i data-lucide="mail" class="w-6 h-6 text-amber-500"></i>
                        </div>
                        <div>
                        <h3 class="font-bold text-lg mb-1">Email</h3>
                        <a href="mailto:inagiofficial@gmail.com" class="text-gray-300 hover:text-white">inagiofficial@gmail.com</a>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="md:w-1/2">
                    <form class="space-y-4" onsubmit="sendToWhatsapp(event)">
                    <div>
                        <label for="name" class="block mb-1 font-medium">Nama Perusahaan / Personal</label>
                        <input type="text" id="name" required class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <label for="email" class="block mb-1 font-medium">Email</label>
                        <input type="email" id="email" required class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <label for="subject" class="block mb-1 font-medium">Subjek</label>
                        <input type="text" id="subject" placeholder="Minta Penawaran Mesin" class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <label for="needs" class="block mb-1 font-medium">Kebutuhan</label>
                        <textarea id="needs" rows="4" required class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:ring-2 focus:ring-amber-500"></textarea>
                    </div>

                    <div>
                        <label for="budget" class="block mb-1 font-medium">Estimasi Budget (Opsional)</label>
                        <input type="text" id="budget" placeholder="Contoh: Rp 10.000.000 - 15.000.000" pattern="^[0-9+\-*/().,\sRp]*$" class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-700 text-white focus:ring-2 focus:ring-amber-500">
                    </div>

                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded font-medium transition-colors duration-300">
                        Minta Penawaran
                    </button>
                    </form>
                </div>
                </div>
            </div>
        </section>
    </main>

<!-- Footer -->
<footer class="bg-gray-900 text-white pt-12 pb-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">

      <!-- Tentang INAGI -->
      <div>
        <h3 class="text-xl font-bold mb-4">INAGI (Inovasi Anak Negeri)</h3>
        <p class="text-gray-400 mb-6">
          Jual adalah perusahaan manufaktur mesin inovatif untuk UMKM dan industri menengah. Kami hadir untuk mendukung pertumbuhan industri lokal menuju pasar global.
        </p>
        <div class="flex space-x-4">
          <a href="https://www.instagram.com/inagiofficial" target="_blank" class="bg-gray-800 p-2 rounded-full hover:bg-amber-600 transition-colors">
            <i data-lucide="instagram" class="w-5 h-5"></i>
          </a>
          <a href="https://www.tiktok.com/@inagiofficial" target="_blank" class="bg-gray-800 p-2 rounded-full hover:bg-amber-600 transition-colors">
            <i data-lucide="video" class="w-5 h-5"></i>
          </a>
          <a href="https://www.youtube.com/c/inagiofficial" target="_blank" class="bg-gray-800 p-2 rounded-full hover:bg-amber-600 transition-colors">
            <i data-lucide="youtube" class="w-5 h-5"></i>
          </a>
          <a href="https://id.linkedin.com/company/inagiofficial" target="_blank" class="bg-gray-800 p-2 rounded-full hover:bg-amber-600 transition-colors">
            <i data-lucide="linkedin" class="w-5 h-5"></i>
          </a>
        </div>
      </div>

      <!-- Navigasi -->
      <div>
        <h3 class="text-lg font-bold mb-4">Navigasi</h3>
        <ul class="space-y-2">
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Beranda</a></li>
          <li><a href="#products" class="text-gray-400 hover:text-white transition-colors">Katalog</a></li>
          <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">Tentang Kami</a></li>
          <li><a href="#projects" class="text-gray-400 hover:text-white transition-colors">Proyek</a></li>
          <li><a href="#news" class="text-gray-400 hover:text-white transition-colors">Artikel</a></li>
          <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">Kontak</a></li>
        </ul>
      </div>

      <!-- Kategori Produk -->
      <div>
        <h3 class="text-lg font-bold mb-4">Kategori Produk</h3>
        <ul class="space-y-2">
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Mesin Retort</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Mesin Pasteurisasi</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Spray Dryer</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Spinner & Oven</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Mesin Blender</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Lihat Semua</a></li>
        </ul>
      </div>

      <!-- Kontak -->
      <div>
        <h3 class="text-lg font-bold mb-4">Kontak Kami</h3>
        <ul class="space-y-3">
          <li class="flex items-start">
            <i data-lucide="map-pin" class="w-5 h-5 mr-3 text-amber-500 flex-shrink-0"></i>
            <span class="text-gray-400">Jl. Manisa No.2, Bumiayu, Kedungkandang, Kota Malang, Jawa Timur 65135</span>
          </li>
          <li class="flex items-center">
            <i data-lucide="phone" class="w-5 h-5 mr-3 text-amber-500 flex-shrink-0"></i>
            <a href="https://wa.me/6281555499975?text=Halo%20INAGI%2C%20saya%20ingin%20konsultasi%20melalui%20website%20%3A%20https%3A%2F%2Finagi.co.id" target="_blank" class="text-gray-400 hover:text-white">
              +62 815-5549-9975
            </a>
          </li>
          <li class="flex items-center">
            <i data-lucide="mail" class="w-5 h-5 mr-3 text-amber-500 flex-shrink-0"></i>
            <a href="mailto:inagiofficial@gmail.com" class="text-gray-400 hover:text-white">inagiofficial@gmail.com</a>
          </li>
          <li class="flex items-center">
            <i data-lucide="clock" class="w-5 h-5 mr-3 text-amber-500 flex-shrink-0"></i>
            <span class="text-gray-400">Senin - Sabtu: 08.00 - 17.00</span>
          </li>
        </ul>
      </div>
    </div>

    <!-- Bottom -->
    <div class="border-t border-gray-800 pt-6">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-400 text-sm mb-4 md:mb-0">© 2025 INAGI. All rights reserved.</p>
        <div class="flex space-x-6">
          <a href="#" class="text-gray-400 text-sm hover:text-white transition-colors">Kebijakan Privasi</a>
          <a href="#" class="text-gray-400 text-sm hover:text-white transition-colors">Syarat & Ketentuan</a>
          <a href="#" class="text-gray-400 text-sm hover:text-white transition-colors">Sitemap</a>
        </div>
      </div>
    </div>
  </div>
</footer>
    <!-- Mobile Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-white shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] md:hidden flex justify-around items-center py-2 z-50">
        
        <!-- Home -->
        <a href="#" class="flex flex-col items-center px-3 py-1 text-amber-600">
            <i data-lucide="home" class="w-5 h-5 mb-1"></i>
            <span class="text-xs font-medium">Home</span>
        </a>
        
        <!-- Katalog -->
        <a href="#products" class="flex flex-col items-center px-3 py-1 text-gray-600 hover:text-amber-600 transition-colors">
            <i data-lucide="shopping-bag" class="w-5 h-5 mb-1"></i>
            <span class="text-xs font-medium">Katalog</span>
        </a>

        <!-- Chat Admin (highlight) -->
        <a href="https://wa.me/6281555499975?text=Halo%20Inagi%2C%20saya%20ingin%20konsultasi" 
        class="flex flex-col items-center px-3 py-1 text-white bg-amber-600 rounded-full shadow-lg animate-pulse transition hover:bg-amber-700">
            <i data-lucide="phone-call" class="w-5 h-5 mb-1"></i>
            <span class="text-xs font-medium">Chat Admin</span>
        </a>

        <!-- Video (YouTube) -->
        <a href="https://www.youtube.com/c/inagiofficial" target="_blank" class="flex flex-col items-center px-3 py-1 text-gray-600 hover:text-amber-600 transition-colors">
            <i data-lucide="video" class="w-5 h-5 mb-1"></i>
            <span class="text-xs font-medium">Video</span>
        </a>

        <!-- Akun -->
        <a href="#login" class="flex flex-col items-center px-3 py-1 text-gray-600 hover:text-amber-600 transition-colors">
            <i data-lucide="user" class="w-5 h-5 mb-1"></i>
            <span class="text-xs font-medium">Akun</span>
        </a>

    </div>
    
    <script>
        // Initialize Lucide icons when DOM is loaded
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
            
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.querySelector('.menu-icon');
            const closeIcon = document.querySelector('.close-icon');
            
            if(mobileMenuButton) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    menuIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('hidden');
                });
            }
            
            // Hero Carousel functionality
            let currentSlide = 0;
            const heroSlides = document.querySelectorAll('.hero-carousel .carousel-item');
            const heroDots = document.querySelectorAll('.hero-carousel .carousel-dot');
            const heroCarouselContainer = document.querySelector('.hero-carousel .carousel-container');
            
            function goToSlide(index) {
                // Update active dot
                heroDots.forEach(dot => dot.classList.remove('active', 'opacity-100'));
                heroDots.forEach(dot => dot.classList.add('opacity-50'));
                heroDots[index].classList.add('active', 'opacity-100');
                
                // Move carousel
                heroCarouselContainer.style.transform = `translateX(-${index * 100}%)`;
                currentSlide = index;
            }
            
            // Initialize first slide
            goToSlide(0);
            
            // Set up dot navigation
            heroDots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    goToSlide(index);
                });
            });
            
            // Automatic sliding
            let heroInterval;
            
            function startHeroCarousel() {
                heroInterval = setInterval(() => {
                    let nextSlide = (currentSlide + 1) % heroSlides.length;
                    goToSlide(nextSlide);
                }, 5000);
            }
            
            function stopHeroCarousel() {
                clearInterval(heroInterval);
            }
            
            startHeroCarousel();
            
            // Pause on hover
            const heroCarousel = document.querySelector('.hero-carousel');
            heroCarousel.addEventListener('mouseenter', stopHeroCarousel);
            heroCarousel.addEventListener('mouseleave', startHeroCarousel);
            
            // Touch events for swiping
            let touchStartX = null;
            
            heroCarousel.addEventListener('touchstart', (e) => {
                touchStartX = e.touches[0].clientX;
            });
            
            heroCarousel.addEventListener('touchend', (e) => {
                if (!touchStartX) return;
                
                const touchEndX = e.changedTouches[0].clientX;
                const diff = touchStartX - touchEndX;
                
                if (Math.abs(diff) > 50) { // Minimum swipe distance
                    if (diff > 0) { // Swipe left
                        let nextSlide = (currentSlide + 1) % heroSlides.length;
                        goToSlide(nextSlide);
                    } else { // Swipe right
                        let prevSlide = (currentSlide - 1 + heroSlides.length) % heroSlides.length;
                        goToSlide(prevSlide);
                    }
                }
                
                touchStartX = null;
            });
            
            // Product Carousels Auto-scroll and pause on hover
            const productCarousels = document.querySelectorAll('.product-carousel');
            
            productCarousels.forEach(carousel => {
                let carouselContainer = carousel.querySelector('.carousel-container');
                let carouselItems = carousel.querySelectorAll('.carousel-item');
                let currentIndex = 0;
                let interval;
                
                function nextProductSlide() {
                    currentIndex = (currentIndex + 1) % carouselItems.length;
                    scrollToCurrentItem();
                }
                
                function scrollToCurrentItem() {
                    const scrollPosition = currentIndex * (carousel.offsetWidth / 1); // Show 1 item on mobile
                    carouselContainer.scroll({
                        left: scrollPosition,
                        behavior: 'smooth'
                    });
                }
                
                function startProductCarousel() {
                    interval = setInterval(nextProductSlide, 4000);
                }
                
                function pauseProductCarousel() {
                    clearInterval(interval);
                }
                
                // Start auto-scrolling
                startProductCarousel();
                
                // Pause on hover or touch
                carousel.addEventListener('mouseenter', pauseProductCarousel);
                carousel.addEventListener('touchstart', pauseProductCarousel);
                carousel.addEventListener('mouseleave', startProductCarousel);
                carousel.addEventListener('touchend', () => {
                    // Small delay before restarting to allow for proper interaction
                    setTimeout(startProductCarousel, 1000);
                });
                
                // Handle touch events for smooth scrolling on mobile
                let isScrolling = false;
                
                carouselContainer.addEventListener('scroll', () => {
                    if (!isScrolling) {
                        clearInterval(interval);
                    }
                    
                    isScrolling = true;
                    clearTimeout(carousel.scrollTimeout);
                    
                    carousel.scrollTimeout = setTimeout(() => {
                        isScrolling = false;
                        if (!carousel.matches(':hover')) {
                            startProductCarousel();
                        }
                    }, 150);
                });
            });
            
            // News Carousel with similar functionality
            const newsCarousel = document.querySelector('.news-carousel');
            if(newsCarousel) {
                const newsContainer = newsCarousel.querySelector('.carousel-container');
                const newsItems = newsCarousel.querySelectorAll('.carousel-item');
                let currentNewsIndex = 0;
                let newsInterval;
                
                function nextNewsSlide() {
                    currentNewsIndex = (currentNewsIndex + 1) % newsItems.length;
                    scrollToCurrentNewsItem();
                }
                
                function scrollToCurrentNewsItem() {
                    const scrollPosition = currentNewsIndex * (newsCarousel.offsetWidth / 1); // Show 1 item on mobile
                    newsContainer.scroll({
                        left: scrollPosition,
                        behavior: 'smooth'
                    });
                }
                
                function startNewsCarousel() {
                    newsInterval = setInterval(nextNewsSlide, 5000);
                }
                
                function pauseNewsCarousel() {
                    clearInterval(newsInterval);
                }
                
                // Start auto-scrolling
                startNewsCarousel();
                
                // Pause on hover or touch
                newsCarousel.addEventListener('mouseenter', pauseNewsCarousel);
                newsCarousel.addEventListener('touchstart', pauseNewsCarousel);
                newsCarousel.addEventListener('mouseleave', startNewsCarousel);
                newsCarousel.addEventListener('touchend', () => {
                    setTimeout(startNewsCarousel, 1000);
                });
                
                // Handle touch events
                let isNewsScrolling = false;
                
                newsContainer.addEventListener('scroll', () => {
                    if (!isNewsScrolling) {
                        clearInterval(newsInterval);
                    }
                    
                    isNewsScrolling = true;
                    clearTimeout(newsCarousel.scrollTimeout);
                    
                    newsCarousel.scrollTimeout = setTimeout(() => {
                        isNewsScrolling = false;
                        if (!newsCarousel.matches(':hover')) {
                            startNewsCarousel();
                        }
                    }, 150);
                });
            }
        });
    </script>
    <!-- Whastapp Konsultasi API -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const currentURL = window.location.href;
            const whatsappNumber = '6281555499975'; // 🔁 Ganti dengan nomor WA kamu
            const message = `Halo Inagi, saya ingin konsultasi%0A Sumber: ${encodeURIComponent(currentURL)}`;
            const whatsappLink = `https://api.whatsapp.com/send?phone=${whatsappNumber}&text=${message}`;

            const desktopBtn = document.getElementById('whatsapp-button');
            const mobileBtn = document.getElementById('whatsapp-button-mobile');

            if (desktopBtn) desktopBtn.href = whatsappLink;
            if (mobileBtn) mobileBtn.href = whatsappLink;
        });
    </script>
    <!-- Artikel API--> 
    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const carouselTrack = document.querySelector("#post-carousel");
            const apiURL = "https://inagi.co.id/wp-json/wp/v2/posts?per_page=10&_embed";

            try {
                const response = await fetch(apiURL);
                const posts = await response.json();

                posts.forEach(post => {
                    const title = post.title.rendered;
                    const excerpt = post.excerpt.rendered.replace(/<[^>]+>/g, '').substring(0, 100) + '...';
                    const date = new Date(post.date).toLocaleDateString('id-ID', {
                        year: 'numeric', month: 'long', day: 'numeric'
                    });
                    const link = post.link;
                    const image = post._embedded && post._embedded['wp:featuredmedia'] && post._embedded['wp:featuredmedia'][0].source_url
                        ? post._embedded['wp:featuredmedia'][0].source_url
                        : 'https://via.placeholder.com/800x480?text=No+Image';

                    const card = `
                        <div class="carousel-item min-w-[300px] max-w-sm flex-shrink-0 h-full">
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 h-full flex flex-col justify-between">
                                <img src="${image}" alt="${title}" class="w-full h-48 object-cover">
                                <div class="p-4 flex flex-col flex-1 justify-between">
                                    <div>
                                        <div class="text-sm text-gray-500 mb-1">${date}</div>
                                        <h3 class="font-bold text-lg mb-2">${title}</h3>
                                        <p class="text-gray-600 mb-3 line-clamp-2">${excerpt}</p>
                                    </div>
                                    <a href="${link}" target="_blank" class="text-amber-600 hover:text-amber-700 font-medium inline-flex items-center mt-auto">
                                        Read More <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                    carouselTrack.insertAdjacentHTML('beforeend', card);
                });

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }

                // ✅ AUTOPLAY SCROLL NEWS — smooth & lambat
                let scrollAmount = 0;
                let scrollStep = 0.5;
                let scrollDelay = 60;

                const autoScroll = () => {
                    scrollAmount += scrollStep;
                    carouselTrack.scrollBy({ left: scrollStep, behavior: 'smooth' });

                    if (scrollAmount >= carouselTrack.scrollWidth - carouselTrack.clientWidth - 1) {
                        scrollAmount = 0;
                        carouselTrack.scrollTo({ left: 0, behavior: 'smooth' });
                    }
                };

                let scrollInterval = setInterval(autoScroll, scrollDelay);

                // Pause saat hover
                carouselTrack.addEventListener('mouseenter', () => {
                    clearInterval(scrollInterval);
                });

                carouselTrack.addEventListener('mouseleave', () => {
                    scrollInterval = setInterval(autoScroll, scrollDelay);
                });

            } catch (error) {
                console.error("Gagal memuat postingan:", error);
            }
        });
    </script>
    <!-- WhatsApp Script -->
    <script>
            function sendToWhatsapp(e) {
                e.preventDefault();

                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const subject = document.getElementById('subject').value.trim();
                const needs = document.getElementById('needs').value.trim();
                const budget = document.getElementById('budget').value.trim();

                const siteURL = window.location.href;

                const message = `
            Halo INAGI, saya ingin minta penawaran:

            *Nama*: ${name}
            *Email*: ${email}
            *Subjek*: ${subject || 'Minta Penawaran Mesin'}
            *Kebutuhan*: ${needs}
            *Estimasi Budget*: ${budget || '-'}
            *Sumber*: ${siteURL}
            `.trim();

                const encodedMessage = encodeURIComponent(message);
                const whatsappURL = `https://wa.me/6281555499975?text=${encodedMessage}`;
                window.open(whatsappURL, '_blank');
            }
    </script>    
	<script src="https://unpkg.com/lucide@latest"></script>
	<script>
	  document.addEventListener("DOMContentLoaded", function () {
		lucide.createIcons();
	  });
	</script>

		
</body>
</html>
