<?php
session_start();
require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Room Gallery - LuckyNest</title>

<link rel="stylesheet" href="style.css">

<style>
.gallery-container{
    width:90%;
    margin:150px auto;
    position:relative;
    z-index:1;
}

.gallery-container h1{
    text-align:center;
    margin-bottom:40px;
}

.room-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));
    gap:30px;
}

.room-card{
    background:white;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    overflow:hidden;
}

.slider{
    position:relative;
    width:100%;
    height:220px;
    overflow:hidden;
    cursor:pointer;
}

.slide{
    width:100%;
    height:220px;
    object-fit:cover;
    display:none;
}

.slide.active{
    display:block;
}

.slider-btn{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    background:rgba(0,0,0,0.5);
    color:white;
    border:none;
    padding:8px 12px;
    cursor:pointer;
    border-radius:5px;
}

.prev{ left:10px; }
.next{ right:10px; }

.room-info{
    padding:20px;
}

.room-info h3{
    margin:0 0 10px 0;
}

.room-info p{
    margin:0 0 15px 0;
    color:#444;
}

.book-btn{
    display:block;
    width:100%;
    padding:12px;
    background:#2ecc71;
    color:white;
    text-align:center;
    border:none;
    border-radius:0 0 12px 12px;
    cursor:pointer;
    font-size:16px;
}

.book-btn:hover{
    background:#27ae60;
}

.lightbox{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.9);
    justify-content:center;
    align-items:center;
    z-index:99999;
}

.lightbox img{
    max-width:80%;
    max-height:80%;
    border-radius:10px;
}

.lightbox-close{
    position:absolute;
    top:20px;
    right:30px;
    font-size:40px;
    color:white;
    cursor:pointer;
}

.lightbox-arrow{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    font-size:50px;
    color:white;
    cursor:pointer;
    padding:10px;
}

.lightbox-prev{ left:40px; }
.lightbox-next{ right:40px; }

.explain-section{
    margin-top:60px;
}

.explain-block{
    display:flex;
    gap:25px;
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    margin-bottom:30px;
}

.explain-block img{
    width:250px;
    height:180px;
    object-fit:cover;
    border-radius:10px;
}

.explain-text{
    flex:1;
}

.explain-text h2{
    margin-top:0;
}
</style>

<script>
function nextSlide(room){
    let slides = document.querySelectorAll(`.${room} .slide`);
    let index = [...slides].findIndex(s => s.classList.contains("active"));
    slides[index].classList.remove("active");
    slides[(index + 1) % slides.length].classList.add("active");
}

function prevSlide(room){
    let slides = document.querySelectorAll(`.${room} .slide`);
    let index = [...slides].findIndex(s => s.classList.contains("active"));
    slides[index].classList.remove("active");
    slides[(index - 1 + slides.length) % slides.length].classList.add("active");
}

let currentImages = [];
let currentIndex = 0;

function openLightbox(roomClass){
    currentImages = [...document.querySelectorAll(`.${roomClass} .slide`)];
    currentIndex = currentImages.findIndex(img => img.classList.contains("active"));

    document.getElementById("lightbox-img").src = currentImages[currentIndex].src;
    document.getElementById("lightbox").style.display = "flex";
}

function closeLightbox(){
    document.getElementById("lightbox").style.display = "none";
}

function lightboxNext(){
    currentIndex = (currentIndex + 1) % currentImages.length;
    document.getElementById("lightbox-img").src = currentImages[currentIndex].src;
}

function lightboxPrev(){
    currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
    document.getElementById("lightbox-img").src = currentImages[currentIndex].src;
}
</script>

</head>

<body>

<div class="gallery-container">

<h1>Room Gallery</h1>

<div class="room-grid">
    <div class="room-card single-room">
        <div class="slider single" onclick="openLightbox('single')">
            <img src="Images/single1.jpg" class="slide active">
            <img src="Images/single2.jpg" class="slide">
            <img src="Images/single3.jpg" class="slide">

            <button class="slider-btn prev" onclick="event.stopPropagation(); prevSlide('single')">&#10094;</button>
            <button class="slider-btn next" onclick="event.stopPropagation(); nextSlide('single')">&#10095;</button>
        </div>

        <div class="room-info">
            <h3>Single Room</h3>
            <p>Perfect for privacy and comfort. Includes WiFi, desk, wardrobe, and shared kitchen access.</p>
            <p><strong>£100/month</strong></p>
        </div>

        <form action="bookRoom.php" method="POST">
            <input type="hidden" name="room_type" value="Single Room">
            <button class="book-btn">Book Room</button>
        </form>
    </div>

    <div class="room-card double-room">
        <div class="slider double" onclick="openLightbox('double')">
            <img src="Images/double1.jpg" class="slide active">
            <img src="Images/double2.jpg" class="slide">
            <img src="Images/double3.jpg" class="slide">

            <button class="slider-btn prev" onclick="event.stopPropagation(); prevSlide('double')">&#10094;</button>
            <button class="slider-btn next" onclick="event.stopPropagation(); nextSlide('double')">&#10095;</button>
        </div>

        <div class="room-info">
            <h3>Double Room</h3>
            <p>Ideal for two residents. Spacious layout with private storage and shared amenities.</p>
            <p><strong>£400/month</strong></p>
        </div>

        <form action="bookRoom.php" method="POST">
            <input type="hidden" name="room_type" value="Double Room">
            <button class="book-btn">Book Room</button>
        </form>
    </div>

    <div class="room-card triple-room">
        <div class="slider triple" onclick="openLightbox('triple')">
            <img src="Images/triple1.jpg" class="slide active">
            <img src="Images/triple2.jpg" class="slide">
            <img src="Images/triple3.jpg" class="slide">

            <button class="slider-btn prev" onclick="event.stopPropagation(); prevSlide('triple')">&#10094;</button>
            <button class="slider-btn next" onclick="event.stopPropagation(); nextSlide('triple')">&#10095;</button>
        </div>

        <div class="room-info">
            <h3>Triple Room</h3>
            <p>Affordable shared living. Includes WiFi, study desks, and access to all facilities.</p>
            <p><strong>£500/month</strong></p>
        </div>

        <form action="bookRoom.php" method="POST">
            <input type="hidden" name="room_type" value="Triple Room">
            <button class="book-btn">Book Room</button>
        </form>
    </div>

</div>

<div id="lightbox" class="lightbox">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <span class="lightbox-arrow lightbox-prev" onclick="lightboxPrev()">&#10094;</span>
    <img id="lightbox-img">
    <span class="lightbox-arrow lightbox-next" onclick="lightboxNext()">&#10095;</span>
</div>

<div class="explain-section">

    <div class="explain-block">
        <img src="Images/single_info.jpg">
        <div class="explain-text">
            <h2>Why Choose a Single Room?</h2>
            <p>Single rooms are perfect for students who value privacy, quiet study time, and personal space. 
               You get your own room, your own desk, and a peaceful environment to focus on your work.</p>
        </div>
    </div>

    <div class="explain-block">
        <img src="Images/double_info.jpg">
        <div class="explain-text">
            <h2>Why Choose a Double Room?</h2>
            <p>Double rooms offer a balance between affordability and comfort. Ideal for friends or roommates 
               who want to share a space while still enjoying a spacious layout.</p>
        </div>
    </div>

    <div class="explain-block">
        <img src="Images/triple_info.jpg">
        <div class="explain-text">
            <h2>Why Choose a Triple Room?</h2>
            <p>Triple rooms are the most budget‑friendly option. Great for social students who enjoy living 
               with others and want to save money while still having access to all amenities.</p>
        </div>
    </div>

</div>

</div>

</body>
</html>
