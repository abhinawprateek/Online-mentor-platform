<?php
require_once 'config.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Platform - Connect with Expert Mentors</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#362C7A',
                        secondary: '#735CC6',
                        tertiary: '#C6B6F7',
                        background: '#F9F5ED'
                    },
                    fontFamily: {
                        sans: ['Segoe UI', 'Tahoma', 'Geneva', 'Verdana', 'sans-serif'],
                        display: ['Poppins', 'Segoe UI', 'Tahoma', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'bounce-in': 'bounceIn 0.5s cubic-bezier(0.36, 0, 0.66, -0.56)',
                        'scale': 'scale 0.3s ease-in-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.3)', opacity: '0' },
                            '50%': { transform: 'scale(1.05)' },
                            '70%': { transform: 'scale(0.9)' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                        scale: {
                            '0%': { transform: 'scale(1)' },
                            '100%': { transform: 'scale(1.05)' },
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
</head>
<body class="font-sans leading-relaxed">

    <!-- Navigation -->
    <nav class="bg-white shadow-md fixed w-full z-20 animate-fade-in">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!--<a class="inline-flex items-center text-xl font-display font-bold tracking-wide no-underline hover:no-underline" href="#">
                    <span class="text-primary">Mentor</span><span class="text-primary">Platform</span>
                </a>-->
                <a class="text-primary text-xl font-bold" href="index.php">Mentor Platform</a>
                <div class="hidden md:flex space-x-4 items-center">
                    <a class="text-gray-600 hover:text-primary transition-colors" href="index.php">Home</a>
                    <a class="text-gray-600 hover:text-primary transition-colors" href="#features">Features</a>
                    <a class="text-gray-600 hover:text-primary transition-colors" href="#how-it-works">How It Works</a>
                    <a class="text-gray-600 hover:text-primary transition-colors" href="about.php">About Us</a>
                    <a class="text-gray-600 hover:text-primary transition-colors" href="contact.php">Contact</a>
                    <a class="text-gray-600 hover:text-primary transition-colors" href="login.php">Login</a>
                    <a class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition-colors" href="register.php">Sign Up</a>
                </div>
                <button class="md:hidden text-gray-600 hover:text-primary" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <a class="block py-2 text-gray-600 hover:text-primary" href="#features">Features</a>
                <a class="block py-2 text-gray-600 hover:text-primary" href="#how-it-works">How It Works</a>
                <a class="block py-2 text-gray-600 hover:text-primary" href="about.php">About Us</a>
                <a class="block py-2 text-gray-600 hover:text-primary" href="contact.php">Contact</a>
                <a class="block py-2 text-gray-600 hover:text-primary" href="login.php">Login</a>
                <a class="block py-2 text-primary font-semibold" href="register.php">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section 
    <section id="top" class="bg-gradient-to-r from-primary to-secondary text-white pt-24 pb-14">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center">
                <div class="w-full lg:w-1/2 mb-8 lg:mb-0 animate-slide-up">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 ml-5">Connect with Expert Mentors</h1>
                    <p class="text-xl mb-8 ml-5">Find the perfect mentor to guide you in your professional and personal development journey.</p>
                    <a href="register.php" class="inline-block bg-white text-primary px-8 py-3 ml-5 rounded-full font-semibold uppercase hover:bg-opacity-90 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        Get Started
                    </a>
                </div>
                <div class="w-full lg:w-1/2 animate-bounce-in mt-5">
                    <img src="assets/images/hero-image.jpg" alt="Mentorship Illustration" class="w-full rounded-2xl shadow-2xl transform hover:scale-105 transition-transform duration-500 object-cover">
                </div>
            </div>
        </div>
    </section>-->

    <section id="top" class="relative bg-cover bg-center h-screen text-white" style="background-image: url('assets/images/hero-image.jpg');">
        <div class="absolute inset-0 bg-primary/70" style="z-index: 2;"></div>
        <div class="container mx-auto px-4 relative z-10 flex items-center justify-center h-full">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-8 animate-slide-up">
                    Unlock Your Potential with Expert Mentorship
                </h1>
                <p class="text-xl md:text-2xl mb-12 animate-fade-in">
                    Connect with experienced mentors who can guide you towards your personal and professional goals.
                </p>
                <a href="register.php" class="inline-block bg-secondary text-white px-8 py-3 rounded-full font-semibold uppercase hover:bg-opacity-90 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg animate-bounce-in">
                    Get Started
                </a>
                <div class="mt-8">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-background">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-4 text-primary animate-slide-up">Why Choose Our Platform?</h2>
            <p class="text-gray-600 text-center mb-12 max-w-2xl mx-auto animate-fade-in">We provide a comprehensive mentorship experience that helps you achieve your goals through personalized guidance and support.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-8 text-center transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl animate-fade-in group" style="animation-delay: 0.2s">
                    <div class="bg-secondary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-secondary/20 transition-colors">
                        <i class="fas fa-user-graduate text-4xl text-secondary group-hover:scale-110 transition-transform"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-primary">Expert Mentors</h3>
                    <p class="text-gray-600 mb-4">Connect with experienced professionals who can guide you in your career and personal growth.</p>
                    <ul class="text-left text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-secondary mr-2"></i> Verified industry experts</li>
                        <li class="flex items-center"><i class="fas fa-check text-secondary mr-2"></i> Years of experience</li>
                        <li class="flex items-center"><i class="fas fa-check text-secondary mr-2"></i> Specialized knowledge</li>
                    </ul>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8 text-center transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl animate-fade-in group" style="animation-delay: 0.4s">
                    <div class="bg-secondary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-secondary/20 transition-colors">
                        <i class="fas fa-calendar-check text-4xl text-secondary group-hover:scale-110 transition-transform"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-primary">Flexible Scheduling</h3>
                    <p class="text-gray-600 mb-4">Book sessions at your convenience with our easy-to-use scheduling system.</p>
                    <ul class="text-left text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-secondary mr-2"></i> 24/7 availability</li>
                        <li class="flex items-center"><i class="fas fa-check text-secondary mr-2"></i> Multiple time zones</li>
                        <li class="flex items-center"><i class="fas fa-check text-secondary mr-2"></i> Instant booking</li>
                    </ul>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8 text-center transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl animate-fade-in group" style="animation-delay: 0.6s">
                    <div class="bg-secondary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-secondary/20 transition-colors">
                        <i class="fas fa-chart-line text-4xl text-secondary group-hover:scale-110 transition-transform"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-primary">Track Progress</h3>
                    <p class="text-gray-600 mb-4">Monitor your development with our comprehensive goal tracking system.</p>
                    <ul class="text-left text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check text-secondary mr-2"></i> Goal setting tools</li>
                        <li class="flex items-center"><i class="fas fa-check text-secondary mr-2"></i> Progress analytics</li>
                        <li class="flex items-center"><i class="fas fa-check text-secondary mr-2"></i> Achievement badges</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-4 text-primary animate-slide-up">How It Works</h2>
            <p class="text-gray-600 text-center mb-12 max-w-2xl mx-auto animate-fade-in">Get started with our platform in four simple steps and begin your journey towards personal and professional growth.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-8 text-center transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl animate-fade-in group" style="animation-delay: 0.2s">
                    <div class="mb-6">
                        <div class="bg-secondary/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto group-hover:bg-secondary/20 transition-colors">
                            <i class="fas fa-user-plus text-4xl text-secondary group-hover:scale-110 transition-transform"></i>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center mx-auto -mt-4 shadow-lg">1</div>
                    </div>
                    <h4 class="text-xl font-semibold mb-3 text-primary">Create Account</h4>
                    <p class="text-gray-600">Sign up as a mentor or mentee and complete your profile with your expertise or learning goals.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8 text-center transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl animate-fade-in group" style="animation-delay: 0.4s">
                    <div class="mb-6">
                        <div class="bg-secondary/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto group-hover:bg-secondary/20 transition-colors">
                            <i class="fas fa-search text-4xl text-secondary group-hover:scale-110 transition-transform"></i>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center mx-auto -mt-4 shadow-lg">2</div>
                    </div>
                    <h4 class="text-xl font-semibold mb-3 text-primary">Find Match</h4>
                    <p class="text-gray-600">Browse through our curated list of mentors and find the perfect match for your needs and goals.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8 text-center transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl animate-fade-in group" style="animation-delay: 0.6s">
                    <div class="mb-6">
                        <div class="bg-secondary/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto group-hover:bg-secondary/20 transition-colors">
                            <i class="fas fa-calendar-alt text-4xl text-secondary group-hover:scale-110 transition-transform"></i>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center mx-auto -mt-4 shadow-lg">3</div>
                    </div>
                    <h4 class="text-xl font-semibold mb-3 text-primary">Schedule Session</h4>
                    <p class="text-gray-600">Book your first mentoring session at a time that works best for both you and your mentor.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8 text-center transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl animate-fade-in group" style="animation-delay: 0.8s">
                    <div class="mb-6">
                        <div class="bg-secondary/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto group-hover:bg-secondary/20 transition-colors">
                            <i class="fas fa-rocket text-4xl text-secondary group-hover:scale-110 transition-transform"></i>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center mx-auto -mt-4 shadow-lg">4</div>
                    </div>
                    <h4 class="text-xl font-semibold mb-3 text-primary">Start Learning</h4>
                    <p class="text-gray-600">Begin your growth journey with personalized guidance and regular feedback from your mentor.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="animate-fade-in" style="animation-delay: 0.2s">
                    <h5 class="text-xl font-semibold mb-4">Mentor Platform</h5>
                    <p class="text-gray-300">Connecting mentors and mentees for professional growth.</p>
                </div>
                <div class="animate-fade-in" style="animation-delay: 0.4s">
                    <h5 class="text-xl font-semibold mb-4">Quick Links</h5>
                    <ul class="space-y-2">
                        <li><a href="about.php" class="text-gray-300 hover:text-tertiary transition-colors duration-300">About Us</a></li>
                        <li><a href="contact.php" class="text-gray-300 hover:text-tertiary transition-colors duration-300">Contact</a></li>
                        <li><a href="index.php" class="text-gray-300 hover:text-tertiary transition-colors duration-300">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="animate-fade-in" style="animation-delay: 0.6s">
                    <h5 class="text-xl font-semibold mb-4">Connect With Us</h5>
                    <div class="flex space-x-4">
                        <a href="https://github.com/Shreyr69"  target="_blank" class="text-gray-300 hover:text-tertiary transition-colors duration-300"><i class="fab fa-github text-xl"></i></a>
                        <a href="https://x.com/ShreyRai369340" target="_blank" class="text-gray-300 hover:text-tertiary transition-colors duration-300"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="https://www.linkedin.com/in/shrey18" target="_blank" class="text-gray-300 hover:text-tertiary transition-colors duration-300"><i class="fab fa-linkedin text-xl"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary my-8">
            <div class="text-center text-gray-300">
                <p>&copy; 2024 Mentor Platform. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle active tab styling based on scroll position
            function updateActiveTab() {
                const sections = [
                    { id: 'top', element: document.getElementById('top') },
                    { id: 'features', element: document.getElementById('features') },
                    { id: 'how-it-works', element: document.getElementById('how-it-works') }
                ];
                
                const navLinks = {
                    'top': document.querySelector('a[href="#"]'),
                    'features': document.querySelector('a[href="#features"]'),
                    'how-it-works': document.querySelector('a[href="#how-it-works"]')
                };

                // Remove active class from all links
                function removeAllActive() {
                    Object.values(navLinks).forEach(link => {
                        if (link) {
                            link.classList.remove('text-primary', 'font-semibold', 'border-b-2', 'border-primary');
                            link.classList.add('text-gray-600', 'hover:text-primary', 'transition-colors');
                        }
                    });
                }

                // Add active class to link
                function setActiveLink(id) {
                    if (navLinks[id]) {
                        removeAllActive();
                        navLinks[id].classList.remove('text-gray-600', 'hover:text-primary');
                        navLinks[id].classList.add('text-primary', 'font-semibold', 'border-b-2', 'border-primary');
                    }
                }

                // Get current scroll position
                const scrollPosition = window.scrollY + 100; // Offset for fixed header

                // Check if we're at the top of the page
                if (scrollPosition < 200) {
                    setActiveLink('top');
                    return;
                }

                // Find the current section
                for (let i = sections.length - 1; i >= 0; i--) {
                    const section = sections[i];
                    if (!section.element) continue;

                    const sectionTop = section.element.offsetTop - 100;
                    const sectionBottom = sectionTop + section.element.offsetHeight;

                    if (scrollPosition >= sectionTop && scrollPosition <= sectionBottom) {
                        setActiveLink(section.id);
                        break;
                    }
                }
            }

            // Throttle function to limit the rate at which updateActiveTab runs
            function throttle(func, limit) {
                let inThrottle;
                return function() {
                    const args = arguments;
                    const context = this;
                    if (!inThrottle) {
                        func.apply(context, args);
                        inThrottle = true;
                        setTimeout(() => inThrottle = false, limit);
                    }
                }
            }

            // Add scroll event listener with throttling
            window.addEventListener('scroll', throttle(updateActiveTab, 100));
            
            // Initial call to set active tab on page load
            updateActiveTab();

            // Handle mobile menu toggle
            const mobileMenuButton = document.querySelector('button[onclick="document.getElementById(\'mobileMenu\').classList.toggle(\'hidden\')"]');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Handle smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').slice(1);
                    const targetElement = document.getElementById(targetId);
                    
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html> 