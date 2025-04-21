<?php
require_once 'config.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message_content = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message_content)) {
        $message = 'Please fill in all fields.';
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        $messageType = 'error';
    } else {
        // Here you would typically send the email
        // For now, we'll just show a success message
        $message = 'Thank you for your message. We will get back to you soon!';
        $messageType = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Mentor Platform</title>
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
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in',
                        'slide-up': 'slideUp 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="font-sans leading-relaxed">
    <!-- Navigation -->
    <nav class="bg-white shadow-md fixed w-full z-10 animate-fade-in">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a class="text-primary text-xl font-bold" href="index.php">Mentor Platform</a>
                <div class="hidden md:flex space-x-4 items-center">
                    <a class="text-gray-600 hover:text-primary transition-colors" href="index.php">Home</a>
                    <a class="text-gray-600 hover:text-primary transition-colors" href="index.php#features">Features</a>
                    <a class="text-gray-600 hover:text-primary transition-colors" href="index.php#how-it-works">How It Works</a>
                    <a class="text-gray-600 hover:text-primary transition-colors" href="about.php">About Us</a>
                    <a class="text-primary font-semibold border-b-2 border-primary" href="contact.php">Contact</a>
                    <a class="text-gray-600 hover:text-primary transition-colors" href="login.php">Login</a>
                    <a class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition-colors" href="register.php">Sign Up</a>
                </div>
                <button class="md:hidden text-gray-600 hover:text-primary" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <a class="block py-2 text-gray-600 hover:text-primary" href="index.php#features">Features</a>
                <a class="block py-2 text-gray-600 hover:text-primary" href="index.php#how-it-works">How It Works</a>
                <a class="block py-2 text-gray-600 hover:text-primary" href="about.php">About Us</a>
                <a class="block py-2 text-gray-600 hover:text-primary" href="contact.php">Contact</a>
                <a class="block py-2 text-gray-600 hover:text-primary" href="login.php">Login</a>
                <a class="block py-2 text-primary font-semibold" href="register.php">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- Contact Hero Section -->
    <section class="bg-gradient-to-r from-primary to-secondary text-white pt-24 pb-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center animate-slide-up">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Contact Us</h1>
                <p class="text-xl mb-8">Have questions? We'd love to hear from you.</p>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-16 bg-background">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <?php if ($message): ?>
                    <div class="mb-8 p-4 rounded-lg <?php echo $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> animate-fade-in">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <div class="bg-white rounded-xl shadow-lg p-8 animate-fade-in">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="text-center p-6 bg-background rounded-lg">
                            <div class="bg-secondary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-envelope text-3xl text-secondary"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-primary mb-2">Email Us</h3>
                            <p class="text-gray-600">shreyrai69@gmail.com</p>
                        </div>
                        <div class="text-center p-6 bg-background rounded-lg">
                            <div class="bg-secondary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-phone text-3xl text-secondary"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-primary mb-2">Call Us</h3>
                            <p class="text-gray-600">+91 62XX 37XX51</p>
                        </div>
                    </div>
                    
                    <form action="contact.php" method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                                    placeholder="Your name">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                                    placeholder="your@email.com">
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" id="subject" name="subject" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                                placeholder="How can we help?">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                                placeholder="Your message..."></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-primary text-white py-3 px-6 rounded-lg hover:bg-opacity-90 transition-colors">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="animate-fade-in">
                    <h5 class="text-xl font-semibold mb-4">Mentor Platform</h5>
                    <p class="text-gray-300">Connecting mentors and mentees for professional growth.</p>
                </div>
                <div class="animate-fade-in">
                    <h5 class="text-xl font-semibold mb-4">Quick Links</h5>
                    <ul class="space-y-2">
                        <li><a href="about.php" class="text-gray-300 hover:text-tertiary transition-colors duration-300">About Us</a></li>
                        <li><a href="contact.php" class="text-gray-300 hover:text-tertiary transition-colors duration-300">Contact</a></li>
                        <li><a href="index.php" class="text-gray-300 hover:text-tertiary transition-colors duration-300">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="animate-fade-in">
                    <h5 class="text-xl font-semibold mb-4">Connect With Us</h5>
                    <div class="flex space-x-4">
                        <a href="https://github.com/Shreyr69" target="_blank" class="text-gray-300 hover:text-tertiary transition-colors duration-300"><i class="fab fa-github text-xl"></i></a>
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
</body>
</html> 