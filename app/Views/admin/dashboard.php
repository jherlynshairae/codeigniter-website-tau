<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAU Admin Panel</title>
    
    <!-- Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="<?= base_url('admin_assets/admin.css') ?>"> 
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            min-height: 100vh;
        }

        /* TAU Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #004d25; /* TAU Green */
            color: #ffffff;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar h2 {
            font-family: 'Oswald', sans-serif;
            font-size: 1.4rem;
            color: #ffcc00; /* TAU Gold */
            letter-spacing: 1px;
            padding: 0 20px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar a {
            color: #e0e0e0;
            text-decoration: none;
            padding: 12px 25px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease-in-out;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #00361a;
            color: #ffcc00;
            border-left: 4px solid #ffcc00;
        }

        .sidebar a[href*="logout"] {
            color: #ff6b6b !important;
            font-weight: bold;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.15) !important;
            padding-top: 15px !important;
        }

        .sidebar a[href*="logout"]:hover {
            background-color: rgba(255, 107, 107, 0.1);
            color: #ff8585 !important;
            border-left: none;
        }

        /* Main Content Layout */
        .main {
            flex: 1;
            padding: 30px;
        }

        .main h1 {
            font-family: 'Oswald', sans-serif;
            font-size: 2rem;
            color: #004d25;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        /* TAU Metric Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: #ffffff;
            padding: 22px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-left: 5px solid #004d25;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        }

        .card:nth-child(2) {
            border-left-color: #ffcc00; /* Gold accent for 2nd card */
        }

        .card:nth-child(3) {
            border-left-color: #0284c7; /* Blue accent for 3rd card */
        }

        .card h2 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .card p {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class="fa-solid fa-graduation-cap"></i> TAU ADMIN</h2>
    <a href="<?= base_url('dashboard') ?>" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="<?= base_url('admin/news') ?>"><i class="fa-solid fa-newspaper"></i> News</a>
    <a href="<?= base_url('admin/announcements') ?>"><i class="fa-solid fa-bullhorn"></i> Announcements</a>
    <a href="<?= base_url('admin/carousel') ?>"><i class="fa-solid fa-images"></i> Carousel</a>
    <a href="<?= base_url('admin/research') ?>"><i class="fa-solid fa-microscope"></i> Research & Dev</a>
    <a href="<?= base_url('admin/users') ?>"><i class="fa-solid fa-users"></i> Users</a>
    <a href="<?= base_url('admin/offices') ?>" class="text-dark text-decoration-none fw-medium">Manage Offices</a>
    
    <a href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
</div>

<div class="main">
    <h1>Dashboard</h1>
    
    <div class="cards">
        <div class="card">
            <h2>15</h2>
            <p>News</p>
        </div>
        <div class="card">
            <h2>8</h2>
            <p>Announcements</p>
        </div>
        <div class="card">
            <h2>5</h2>
            <p>Carousel Slides</p>
        </div>
    </div>
</div>

</body>
</html>