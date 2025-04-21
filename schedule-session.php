<?php
require_once 'config.php';

// Check if user is logged in and is a mentee
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mentee') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

// Get user data
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    
    // Get available mentors
    $stmt = $conn->prepare("
        SELECT u.*, mp.hourly_rate, mp.availability
        FROM users u
        JOIN mentor_profiles mp ON u.user_id = mp.mentor_id
        WHERE u.user_id IN (
            SELECT DISTINCT mentor_id 
            FROM mentor_profiles 
            WHERE mentor_id NOT IN (
                SELECT mentor_id 
                FROM sessions 
                WHERE status = 'scheduled' 
                AND start_time >= NOW()
            )
        )
    ");
    $stmt->execute();
    $mentors = $stmt->fetchAll();
    
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Handle session scheduling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $mentor_id = (int)$_POST['mentor_id'];
        $start_time = sanitize_input($_POST['start_time']);
        $duration = (int)$_POST['duration'];
        $notes = sanitize_input($_POST['notes']);
        
        // Validate input
        if (empty($mentor_id) || empty($start_time) || empty($duration)) {
            $error = "Please fill in all required fields";
        } else {
            // Check if mentor is available
            $stmt = $conn->prepare("
                SELECT COUNT(*) as count 
                FROM sessions 
                WHERE mentor_id = ? 
                AND status = 'scheduled' 
                AND start_time <= DATE_ADD(?, INTERVAL ? HOUR)
                AND DATE_ADD(start_time, INTERVAL 1 HOUR) >= ?
            ");
            $stmt->execute([$mentor_id, $start_time, $duration, $start_time]);
            $result = $stmt->fetch();
            
            if ($result['count'] > 0) {
                $error = "Mentor is not available at this time";
            } else {
                // Calculate end time
                $end_time = date('Y-m-d H:i:s', strtotime($start_time . ' + ' . $duration . ' hours'));
                
                // Insert session
                $stmt = $conn->prepare("
                    INSERT INTO sessions (mentor_id, mentee_id, start_time, end_time, notes)
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->execute([$mentor_id, $user_id, $start_time, $end_time, $notes]);
                
                $success = "Session scheduled successfully!";
                
                // Redirect to sessions page after 2 seconds
                header("refresh:2;url=sessions.php");
            }
        }
    } catch(PDOException $e) {
        $error = "An error occurred. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Session - Mentor Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#362C7A',
                        secondary: '#735CC6',
                        tertiary: '#C6B6F7',
                        background: '#F9F5ED',
                        white: '#FFFFFF'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-in': 'slideIn 0.5s ease-out',
                        'scale': 'scale 0.3s ease-in-out',
                        'bounce-in': 'bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55)'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideIn: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        scale: {
                            '0%': { transform: 'scale(1)' },
                            '100%': { transform: 'scale(1.02)' }
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.3)', opacity: '0' },
                            '50%': { transform: 'scale(1.05)', opacity: '0.8' },
                            '70%': { transform: 'scale(0.9)', opacity: '0.9' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .mentor-card {
            transition: all 0.3s ease;
        }
        .mentor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(54, 44, 122, 0.1);
        }
        .mentor-image {
            transition: all 0.3s ease;
        }
        .mentor-card:hover .mentor-image {
            transform: scale(1.05);
            border-color: #735CC6;
        }
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            border-color: #735CC6;
            box-shadow: 0 0 0 3px rgba(115, 92, 198, 0.1);
        }
        .submit-button {
            transition: all 0.3s ease;
        }
        .submit-button:hover {
            transform: translateY(-2px);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-background font-['Segoe_UI',_Tahoma,_Geneva,_Verdana,_sans-serif]">
    <div class="flex animate-fade-in">
        <!-- Sidebar -->
        <div class="w-64 bg-white min-h-screen shadow-lg py-5 flex-shrink-0 border-r border-tertiary">
            <div class="text-center mb-4">
                <img src="<?php echo $user['profile_picture'] ? UPLOAD_URL . $user['profile_picture'] : 'assets/images/default-avatar.jpg'; ?>" 
                     alt="Profile Picture" 
                     class="w-[100px] h-[100px] rounded-full object-cover mx-auto mb-4 border-[3px] border-secondary shadow-lg transition-all duration-300 hover:scale-110 hover:border-primary">
                <h5 class="text-lg font-semibold text-primary"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                <p class="text-secondary">Mentee</p>
            </div>
            
            <nav class="space-y-1 px-3">
                <a class="flex items-center px-5 py-2.5 rounded-md text-primary transition-all duration-300 hover:bg-tertiary hover:text-primary" href="dashboard.php">
                    <i class="fas fa-home w-5 mr-2.5"></i> Dashboard
                </a>
                <a class="flex items-center px-5 py-2.5 rounded-md text-primary transition-all duration-300 hover:bg-tertiary hover:text-primary" href="profile.php">
                    <i class="fas fa-user w-5 mr-2.5"></i> Profile
                </a>
                <a class="flex items-center px-5 py-2.5 rounded-md text-primary transition-all duration-300 hover:bg-tertiary hover:text-primary" href="messages.php">
                    <i class="fas fa-comments w-5 mr-2.5"></i> Messages
                </a>
                <a class="flex items-center px-5 py-2.5 rounded-md text-primary bg-tertiary" href="sessions.php">
                    <i class="fas fa-calendar w-5 mr-2.5"></i> Sessions
                </a>
                <a class="flex items-center px-5 py-2.5 rounded-md text-primary transition-all duration-300 hover:bg-tertiary hover:text-primary" href="goals.php">
                    <i class="fas fa-bullseye w-5 mr-2.5"></i> Goals
                </a>
                <a class="flex items-center px-5 py-2.5 rounded-md text-primary transition-all duration-300 hover:bg-tertiary hover:text-primary" href="mentee-resources.php">
                    <i class="fas fa-book w-5 mr-2.5"></i> Resources
                </a>
                <a class="flex items-center px-5 py-2.5 rounded-md text-primary transition-all duration-300 hover:bg-tertiary hover:text-primary" href="find-mentor.php">
                    <i class="fas fa-search w-5 mr-2.5"></i> Find Mentor
                </a>
                <a class="flex items-center px-5 py-2.5 rounded-md text-white bg-red-500 transition-all duration-300 hover:bg-red-600" href="logout.php">
                    <i class="fas fa-sign-out-alt w-5 mr-2.5"></i> Logout
                </a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-8 animate-slide-in">
            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 animate-bounce-in"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 animate-bounce-in"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="bg-white rounded-xl shadow-lg border border-tertiary/30 mb-6">
                <div class="p-5 border-b border-tertiary/30">
                    <h1 class="text-2xl font-bold text-primary m-0">Schedule New Session</h1>
                </div>
                <div class="p-5">
                    <form method="POST" action="" id="scheduleForm">
                        <!-- Mentor Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-primary mb-2">Select Mentor</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <?php foreach ($mentors as $mentor): ?>
                                    <div class="group">
                                        <div class="mentor-card bg-white rounded-xl shadow-lg border border-tertiary/30 transition-all duration-300 cursor-pointer peer-checked:border-2 peer-checked:border-primary" 
                                             onclick="selectMentor(<?php echo $mentor['user_id']; ?>)">
                                            <div class="p-5 text-center">
                                                <img src="<?php echo $mentor['profile_picture'] ? UPLOAD_URL . $mentor['profile_picture'] : 'assets/images/default-avatar.jpg'; ?>" 
                                                     alt="Profile Picture" 
                                                     class="mentor-image w-[60px] h-[60px] rounded-full object-cover mx-auto mb-3 border-2 border-secondary shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:border-primary">
                                                <h6 class="text-lg font-semibold text-primary mb-1">
                                                    <?php echo htmlspecialchars($mentor['first_name'] . ' ' . $mentor['last_name']); ?>
                                                </h6>
                                                <p class="text-secondary mb-1">$<?php echo number_format($mentor['hourly_rate'], 2); ?>/hour</p>
                                                <small class="text-secondary"><?php echo htmlspecialchars($mentor['availability']); ?></small>
                                                <input type="radio" 
                                                       name="mentor_id" 
                                                       value="<?php echo $mentor['user_id']; ?>" 
                                                       class="hidden peer" 
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Session Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-primary mb-2">Start Time</label>
                                <input type="datetime-local" 
                                       id="start_time" 
                                       name="start_time" 
                                       class="form-input w-full px-4 py-2 rounded-lg border border-tertiary focus:outline-none focus:ring-2 focus:ring-tertiary" 
                                       required>
                            </div>
                            
                            <div>
                                <label for="duration" class="block text-sm font-medium text-primary mb-2">Duration (hours)</label>
                                <select id="duration" 
                                        name="duration" 
                                        class="form-input w-full px-4 py-2 rounded-lg border border-tertiary focus:outline-none focus:ring-2 focus:ring-tertiary" 
                                        required>
                                    <option value="1">1 hour</option>
                                    <option value="2">2 hours</option>
                                    <option value="3">3 hours</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Session Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-primary mb-2">Session Notes (Optional)</label>
                            <textarea id="notes" 
                                      name="notes" 
                                      rows="4" 
                                      class="form-input w-full px-4 py-2 rounded-lg border border-tertiary focus:outline-none focus:ring-2 focus:ring-tertiary"
                                      placeholder="Add any specific topics or questions you'd like to discuss during the session"></textarea>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="submit-button px-6 py-2 bg-primary hover:bg-secondary text-white rounded-lg transition-all duration-300">
                                Schedule Session
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function selectMentor(mentorId) {
            // Remove selected class from all cards
            document.querySelectorAll('.mentor-card').forEach(card => {
                card.classList.remove('border-2', 'border-primary');
            });
            
            // Add selected class to clicked card
            event.currentTarget.classList.add('border-2', 'border-primary');
            
            // Check the radio button
            document.querySelector(`input[value="${mentorId}"]`).checked = true;
        }
        
        // Form validation
        document.getElementById('scheduleForm').addEventListener('submit', function(e) {
            const mentorSelected = document.querySelector('input[name="mentor_id"]:checked');
            if (!mentorSelected) {
                e.preventDefault();
                alert('Please select a mentor');
            }
        });
    </script>
</body>
</html> 