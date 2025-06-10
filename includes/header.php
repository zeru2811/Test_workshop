<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Auto Workshop Finder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        myanmar: ['Noto Sans Myanmar', 'sans-serif']
                    },
                    colors: {
                        primary: "#0EA5E9",
                        secondary: "#64748B",
                    },
                    borderRadius: {
                        none: "0px",
                        sm: "4px",
                        DEFAULT: "8px",
                        md: "12px",
                        lg: "16px",
                        xl: "20px",
                        "2xl": "24px",
                        "3xl": "32px",
                        full: "9999px",
                        button: "8px",
                    },
                },
            },
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet" />
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        .map-container {
            background-image: url('https://public.readdy.ai/gen_page/map_placeholder_1280x720.png');
            background-position: center;
            background-size: cover;
        }

        @keyframes progress {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        .animate-progress {
            animation: progress 3s linear forwards;
        }

        /* Hide desktop nav on mobile */
        @media (max-width: 768px) {
            .desktop-nav {
                display: none;
            }
        }

        /* Show mobile nav on mobile */
        @media (min-width: 769px) {
            .mobile-nav {
                display: none;
            }
        }

        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Desktop Navigation -->
    <nav class="desktop-nav bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <a href="index.php" class="flex items-center">
                    <img src="../logo.png" alt="logo" style="width:100px;height:35px;object-fit:cover;">
                </a>
                <div class="flex items-center space-x-8">
                    <button id="translateBtn" class="px-3 py-1 border rounded-button text-sm hover:bg-gray-100"
                        onclick="toggleLanguage()">
                        MY
                    </button>
                    <a href="<?= ($_SESSION['user_type'] ?? '') === 'workshop' ? 'dashboard.php' : '../public/index.php' ?>" 
                       class="block text-gray-700 hover:text-primary" 
                       data-translate="home">
                       Home
                    </a>
                    <?php if (($_SESSION['user_type'] ?? '') === 'customer'): ?>
                        <a href="book.php" class="text-gray-700 hover:text-primary" data-translate="book">Book Now</a>
                    <?php endif; ?>
                    <?php if (($_SESSION['user_type'] ?? '') === 'workshop'): ?>
                        <a href="status_management.php" class="block text-gray-700 hover:text-gray-900">
                            <i class="ri-calendar-todo-line mr-2"></i> Manage Bookings
                        </a>
                    <?php endif; ?>
                    <a href="../public/account.php" class="flex items-center space-x-2 text-gray-700 hover:text-primary">
                        <i class="ri-user-line w-5 h-5 flex items-center justify-center"></i>
                        <span data-translate="account">Account</span>
                    </a>

                    <!-- <a href="../auth/logout.php" class="text-gray-700 hover:text-primary" data-translate="Logout">Logout Now</a> -->
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation -->
    <nav class="mobile-nav bg-white shadow-sm">
        <div class="px-4">
            <div class="flex justify-between items-center h-16">
                <span class="text-2xl font-['Pacifico'] text-primary">logo</span>
                <div class="flex items-center space-x-4">
                    <button id="mobileTranslateBtn" class="px-3 py-1 border rounded-button text-sm hover:bg-gray-100"
                        onclick="toggleLanguage()">
                        MY
                    </button>
                    <a href="../public/account.php" class="flex items-center text-gray-700 hover:text-primary">
                        <i class="ri-user-line w-5 h-5 flex items-center justify-center"></i>
                    </a>
                    <button class="mobile-menu-button p-2" onclick="toggleMobileMenu()">
                        <i class="ri-menu-line text-2xl"></i>
                    </button>
                </div>
            </div>
            <!-- Mobile Menu Items -->
            <div id="mobileMenu" class="hidden pb-4 space-y-4 border-t">
                <a href="<?= ($_SESSION['user_type'] ?? '') === 'workshop' ? 'dashboard.php' : '../public/index.php' ?>" 
                   class="block text-gray-700 hover:text-primary" 
                   data-translate="home">
                   Home
                </a>
                <?php if (($_SESSION['user_type'] ?? '') === 'customer'): ?>
                    <a href="book.php" class="text-gray-700 hover:text-primary" data-translate="book">Book Now</a>
                <?php endif; ?>
                <?php if (($_SESSION['user_type'] ?? '') === 'workshop'): ?>
                    <a href="status_management.php" class="block text-gray-700 hover:text-gray-900">
                        <i class="ri-calendar-todo-line mr-2"></i> Manage Bookings
                    </a>
                <?php endif; ?>
                <!-- <a href="../auth/logout.php" class="text-gray-700 hover:text-primary" data-translate="Logout">Logout Now</a> -->
            </div>
        </div>
    </nav>