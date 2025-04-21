# Mentor Platform

A comprehensive web-based mentorship platform that connects mentors with mentees, facilitating knowledge sharing and professional growth.

## Features

### For Mentees
- 🎯 **Goal Setting & Tracking**
  - Create and manage personal learning goals
  - Track progress with percentage completion
  - Receive resources aligned with goals

- 🔍 **Find Mentors**
  - Search mentors by expertise and availability
  - View mentor profiles with ratings and reviews
  - Filter by hourly rate and specialization

- 📚 **Resource Access**
  - Access mentor-shared learning materials
  - Track resource completion
  - Organize resources by goals

- 📅 **Session Management**
  - Schedule sessions with mentors
  - View upcoming and past sessions
  - Leave reviews after completed sessions

### For Mentors
- 📊 **Analytics Dashboard**
  - Track earnings and session statistics
  - View mentee engagement metrics
  - Monitor resource usage

- 📚 **Resource Management**
  - Upload and organize learning materials
  - Share resources with specific mentees
  - Track resource engagement

- 💰 **Earnings Management**
  - Set hourly rates
  - Track session earnings
  - View payment history

- 📅 **Session Control**
  - Manage session schedules
  - Mark sessions as completed
  - View session history

### Common Features
- 💬 **Messaging System**
  - Real-time chat between mentors and mentees
  - File sharing capabilities
  - Message notifications

- 👤 **Profile Management**
  - Customizable user profiles
  - Profile picture upload
  - Skills and interests listing

## Technical Requirements

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- XAMPP/WAMP/MAMP (for local development)

### Database
- InnoDB engine
- UTF-8 Unicode character set
- Supports foreign key constraints

## Installation

1. **Clone the Repository**
   ```bash
   git clone [repository-url]
   cd mentor-platform
   ```

2. **Database Setup**
   - Create a new MySQL database
   - Import the database structure:
     ```bash
     mysql -u [username] -p [database_name] < database.sql
     ```

3. **Configuration**
   - Copy `config.example.php` to `config.php`
   - Update database credentials in `config.php`:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'mentor_platform');
     ```

4. **File Permissions**
   - Set appropriate permissions for upload directories:
     ```bash
     chmod 755 uploads/
     chmod 755 assets/
     ```

5. **Web Server Configuration**
   - Point your web server to the project directory
   - Ensure PHP has write permissions for upload directories

## Directory Structure

```
mentor-platform/
├── assets/           # Static assets (CSS, JS, images)
├── uploads/          # User uploaded files
├── includes/         # PHP includes
├── config.php       # Configuration file
├── database.sql     # Database structure
└── various .php     # Main application files
```

## Security Features

- Password hashing using bcrypt
- SQL injection prevention using prepared statements
- XSS protection with output escaping
- CSRF protection for forms
- Secure file upload handling

## User Roles

### Mentor
- Can upload resources
- Manage sessions
- View analytics
- Track earnings

### Mentee
- Set learning goals
- Access resources
- Schedule sessions
- Leave reviews

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, please email [support-email] or create an issue in the repository.

## Acknowledgments

- Built with PHP and MySQL
- Uses Tailwind CSS for styling
- Font Awesome for icons
- Chart.js for analytics 