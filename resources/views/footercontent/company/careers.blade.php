<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karir - KosKu</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    
    

    <script src="https://cdn.tailwindcss.com"></script>
      <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        /* Button search navbar bentuk oval/lonjong */
        .nav-search-btn {
            border-radius: 24px !important;
            padding: 4px 14px !important;
            min-width: 42px !important;
            height: 30px !important;
            width: auto !important;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            padding-top: 80px;
            zoom: 0.9;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
        }

        .section-card {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .section-card:hover {
            border-color: rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <!-- Hero Section -->
    <section class="bg-black text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">Bergabung dengan Tim Kami</h1>
                <p class="text-lg text-gray-300 mb-8">
                    Mari bersama membangun masa depan hunian yang lebih baik untuk Indonesia
                </p>
             
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-16">
        <!-- Open Positions -->
        <section id="positions" class="space-y-6">
            <h2 class="text-2xl font-bold mb-8">Posisi yang Tersedia</h2>
            
            <!-- Engineering -->
            <div class="section-card rounded-xl p-8 shadow-sm hover-lift">
                <h3 class="text-xl font-bold mb-6">Engineering</h3>
                <div class="space-y-4">
                    <a href="#" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold mb-1">Senior Full-Stack Developer</h4>
                                <p class="text-sm text-gray-600">Jakarta • Full-time</p>
                            </div>
                            <span class="px-3 py-1 bg-black text-white text-sm rounded-full">Senior</span>
                        </div>
                    </a>
                    
                    <a href="#" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold mb-1">Frontend Developer</h4>
                                <p class="text-sm text-gray-600">Jakarta • Full-time</p>
                            </div>
                            <span class="px-3 py-1 bg-black text-white text-sm rounded-full">Mid-Level</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Product & Design -->
            <div class="section-card rounded-xl p-8 shadow-sm hover-lift">
                <h3 class="text-xl font-bold mb-6">Product & Design</h3>
                <div class="space-y-4">
                    <a href="#" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold mb-1">UI/UX Designer</h4>
                                <p class="text-sm text-gray-600">Jakarta • Full-time</p>
                            </div>
                            <span class="px-3 py-1 bg-black text-white text-sm rounded-full">Senior</span>
                        </div>
                    </a>
                    
                    <a href="#" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold mb-1">Product Manager</h4>
                                <p class="text-sm text-gray-600">Jakarta • Full-time</p>
                            </div>
                            <span class="px-3 py-1 bg-black text-white text-sm rounded-full">Mid-Level</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Marketing -->
            <div class="section-card rounded-xl p-8 shadow-sm hover-lift">
                <h3 class="text-xl font-bold mb-6">Marketing</h3>
                <div class="space-y-4">
                    <a href="#" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold mb-1">Digital Marketing Specialist</h4>
                                <p class="text-sm text-gray-600">Jakarta • Full-time</p>
                            </div>
                            <span class="px-3 py-1 bg-black text-white text-sm rounded-full">Mid-Level</span>
                        </div>
                    </a>
                    
                    <a href="#" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold mb-1">Content Writer</h4>
                                <p class="text-sm text-gray-600">Jakarta • Full-time</p>
                            </div>
                            <span class="px-3 py-1 bg-black text-white text-sm rounded-full">Junior</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section class="mt-12 section-card rounded-xl p-8 text-center">
            <h3 class="text-xl font-bold mb-6">Tidak Menemukan Posisi yang Sesuai?</h3>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                Kirimkan CV Anda ke email kami. Kami selalu mencari talenta-talenta berbakat untuk bergabung dengan tim KosKu.
            </p>
            <a href="mailto:careers@kosku.com" class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Kirim CV
            </a>
        </section>
    </main>

    <!-- Footer Wrapper -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @include('components.footer')
    </div>
</body>
</html>