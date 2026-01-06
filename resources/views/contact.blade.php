<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | HaraTrading</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Get in touch with HaraTrading. We're here to answer your questions and provide support.">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #7b2cbf;
            --primary-light: #9d4edd;
            --secondary: #00b4d8;
            --secondary-light: #48cae4;
            --dark: #0d0d1a;
            --darker: #070710;
            --light: #f8f9fa;
            --accent: #ff9e00;
            --glass: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(123, 44, 191, 0.25);
            --success: #4bb543;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        html, body {
            height: 100%;
            scroll-behavior: smooth;
        }
        
        body {
            background: linear-gradient(135deg, var(--dark) 0%, #18182f 100%);
            color: var(--light);
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated background elements */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(123, 44, 191, 0.1) 0%, transparent 70%);
            animation: float 15s infinite alternate ease-in-out;
            z-index: -1;
        }
        
        body::after {
            content: '';
            position: absolute;
            bottom: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 180, 216, 0.1) 0%, transparent 70%);
            animation: float 18s infinite alternate-reverse ease-in-out;
            z-index: -1;
        }
        
        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }
            50% {
                transform: translate(-5%, -5%) rotate(5deg);
            }
            100% {
                transform: translate(5%, 5%) rotate(-5deg);
            }
        }
        
        .contact-outer {
            width: 100%;
            max-width: 1200px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .contact-container {
            background: var(--glass);
            border: 1.5px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
            padding: 2.5rem;
            width: 100%;
            max-width: 480px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .contact-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.4);
        }
        
        .contact-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .contact-container h2 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .contact-container h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 3px;
        }
        
        .contact-container h2 i {
            margin-right: 0.75rem;
            font-size: 1.8rem;
        }
        
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }
        
        .form-group {
            position: relative;
        }
        
        .contact-form label {
            display: block;
            font-weight: 600;
            color: var(--secondary-light);
            margin-bottom: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 1rem 1.2rem;
            border: 1.5px solid var(--glass-border);
            border-radius: 10px;
            background: rgba(25, 25, 51, 0.7);
            color: var(--light);
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
            outline: none;
            transition: all 0.3s ease;
            resize: none;
        }
        
        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(123, 44, 191, 0.2);
            background: rgba(25, 25, 51, 0.9);
        }
        
        .contact-form textarea {
            min-height: 140px;
            max-height: 240px;
        }
        
        .contact-form button {
            width: 100%;
            padding: 1.1rem;
            border: none;
            border-radius: 50px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(123, 44, 191, 0.2);
            transition: all 0.3s ease;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .contact-form button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
        }
        
        .contact-form button:hover {
            background: linear-gradient(90deg, var(--primary-light), var(--secondary-light));
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(123, 44, 191, 0.3);
        }
        
        .contact-form button:hover::before {
            left: 100%;
        }
        
        .contact-form button:active {
            transform: translateY(1px);
        }
        
        .contact-form button i {
            transition: transform 0.3s ease;
        }
        
        .contact-form button:hover i {
            transform: translateX(3px);
        }
        
        .contact-info {
            text-align: center;
            margin-top: 2.5rem;
            color: rgba(191, 201, 209, 0.8);
            font-size: 0.98rem;
        }
        
        .contact-info p {
            margin-bottom: 1rem;
        }
        
        .contact-info a {
            color: var(--secondary-light);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
        }
        
        .contact-info a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }
        
        .contact-info a:hover {
            color: var(--primary);
        }
        
        .contact-info a:hover::after {
            width: 100%;
        }
        
        .contact-info i {
            margin-right: 0.5rem;
            transition: transform 0.3s ease;
        }
        
        .contact-info a:hover i {
            transform: translateX(3px);
        }
        
        /* Success message */
        .success-message {
            display: none;
            text-align: center;
            padding: 1.5rem;
            background: rgba(75, 181, 67, 0.1);
            border: 1px solid var(--success);
            border-radius: 10px;
            margin-top: 1.5rem;
            animation: fadeIn 0.5s ease;
        }
        
        .success-message i {
            color: var(--success);
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .success-message p {
            color: var(--light);
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .contact-outer {
                padding: 1rem;
            }
            
            .contact-container {
                padding: 2rem 1.5rem;
            }
            
            .contact-container h2 {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 500px) {
            .contact-container {
                padding: 1.5rem 1rem;
                border-radius: 18px;
            }
            
            .contact-container h2 {
                font-size: 1.5rem;
            }
            
            .contact-form input,
            .contact-form textarea {
                padding: 0.9rem 1rem;
                font-size: 0.95rem;
            }
            
            .contact-form button {
                padding: 1rem;
                font-size: 1rem;
            }
            
            .contact-info {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 400px) {
            .contact-container {
                padding: 1.2rem 0.8rem;
            }
            
            .contact-container h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="contact-outer">
        <div class="contact-container">
            <h2><i class="fas fa-envelope"></i>Contact Us</h2>
            <form class="contact-form" id="contactForm" action="mailto:support@haratrading.com" method="POST" enctype="text/plain" autocomplete="off">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="Name" required placeholder="Your Name">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="Email" required placeholder="you@email.com">
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="Message" rows="5" required placeholder="How can we help you?"></textarea>
                </div>

                <button type="submit"><i class="fas fa-paper-plane"></i> Send Message</button>
            </form>
            
            <div class="success-message" id="successMessage">
                <i class="fas fa-check-circle"></i>
                <p>Thank you for your message!</p>
                <p>We'll get back to you soon.</p>
            </div>
            
            <div class="contact-info">
                <p>Or email us directly at <a href="mailto:support@haratrading.com">support@haratrading.com</a></p>
                <p>Join our <a href="http://t.me/Haratrading" target="_blank" rel="noopener noreferrer"><i class="fab fa-telegram-plane"></i> Telegram community</a></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // In a real implementation, you would send the form data to a server here
            // For this demo, we'll just show the success message
            
            // Show success message
            document.getElementById('successMessage').style.display = 'block';
            
            // Reset form
            this.reset();
            
            // Scroll to success message
            document.getElementById('successMessage').scrollIntoView({
                behavior: 'smooth'
            });
            
            // Hide form
            this.style.display = 'none';
            
            // After 5 seconds, you could redirect or do something else
            // setTimeout(() => { window.location.href = '/thank-you'; }, 5000);
        });
    </script>
</body>
</html>