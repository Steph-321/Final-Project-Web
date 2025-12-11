<?php

session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

include 'db_connect.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT firstname, lastname, email, contact FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Purple Yam Bakeshop</title>
    <link rel="icon" href="../assets/logo.png" type="image/png" />
    <link rel="stylesheet" href="../styles/style.css" />
</head>

<body>
        <header>
        <div class="logo">
            <img src="../assets/logo.png" alt="Purple Yam Logo" />
            <h1>PURPLE YAM</h1>
        </div>

        <nav class="main-nav">
            <ul>
                <li><a href="account.php">Home</a></li>
                <li><a href="account.php#menu">Menu</a></li>
                <li><a href="account.php#about">About</a></li>
                <li><a href="#menu" class="stores-trigger">Stores</a></li>
            </ul>
        </nav>

        <div class="auth-links">
            <a href="order.php">
                <img src="../assets/cart.png" alt="Cart">
            </a>
            <a href="userPage.php">
                <img src="../assets/profile-picture.png" alt="User" class="user-icon" />
                <span>Account</span>
            </a>
        </div>
    </header>

    <section class="hero">
        <h1>Welcome to Purple Yam</h1>
        <p>Delicious cakes and pastries made with love and the finest ingredients</p>
        <div class="hero-buttons">
            <a href="#menu" class="btn">Browse Products</a>
            <a href="#about" class="btn">Learn More</a>
        </div>
    </section>

    <main id="menu">
        <section class="spots-section">
            <h2>Menu</h2>
            <nav class="category-tabs">
                <button onclick="showCategory('ube')">CLASSIC UBE CAKES</button>
                <button onclick="showCategory('brazo')">BRAZO DE MERCEDES</button>
                <button onclick="showCategory('choco')">CHOCO MOIST</button>
                <button onclick="showCategory('custard')">UBE CUSTARD</button>
                <button onclick="showCategory('creamcheese')">UBE CREAMCHEESE BARS</button>
                <button onclick="showCategory('calamansi')">UBE CALAMANSI BARS</button>
            </nav>

            <div id="ube" class="category-section">
                <div class="spots-grid">
                    <div class="spot-card">
                        <h3>CLASSIC UBE CAKES</h3>
                        <p>Soft, moist, and unforgettable. Served with coffee or on its own.</p>
                        <div class="variant-row">
                            <div class="variant-box">
                                <img src="../assets/photos/cakemedium.jpg" alt="Medium">
                                <span class="variant-price">₱610-₱920</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Purple Yam Cake',
                    'Soft, moist, and unforgettable. Served with coffee or on its own.',
                    '../assets/photos/cakemedium.jpg',
                    [
                      { label: 'Large', price: 920, img: '../assets/photos/cakemedium.jpg', description: 'A generously sized ube cake, soft and moist with rich yam flavor. Perfect for celebrations, family gatherings, or sharing with a crowd.' },
                      { label: 'Medium', price: 610, img: '../assets/photos/cake3.jpg', description: 'A medium-sized version of our classic ube cake, ideal for smaller gatherings or intimate occasions. Still packed with flavor, it offers just the right amount for a cozy treat.' }
                    ]
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>

                            <div class="variant-box">
                                <img src="../assets/photos/cake.jpg" alt="Round">
                                <span class="variant-price">₱490</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Purple Yam Cake',
                    'A round and heart-shaped version of our classic ube cake, soft and moist with a rich yam flavor.',
                    '../assets/photos/cake.jpg',
                    [
                      {
                        label: 'Round',
                        price: 490,
                        img: '../assets/photos/cake.jpg',
                        description: 'A round version of our classic ube cake, soft and moist with a rich yam flavor. Its traditional shape makes it a timeless centerpiece for any occasion, whether served with coffee or enjoyed on its own.'
                      },
                      {
                        label: 'Heart',
                        price: 490,
                        img: '../assets/photos/cake5.jpg',
                        description: 'A heart‑shaped ube cake, perfect for sharing love and sweetness. With its vibrant purple hue and tender texture, it’s a thoughtful way to celebrate special moments with family and friends..'
                      }
                    ]
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>

                            <div class="variant-box">
                                <img src="../assets/photos/cakesalata.jpg" alt="Tincan Round">
                                <span class="variant-price">₱340–₱360</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Purple Yam Cake (Tincan)',
                    'Special ube cake in tin containers, available in round or heart shapes.',
                    '../assets/photos/cakesalata.jpg',
                    [
                      { label: 'Tincan Round', price: 340, img: '../assets/photos/cakesalata.jpg', description: 'A round tin ube cake, compact and perfect for gifting. Its neat presentation and rich flavor make it a delightful treat to share or enjoy on the go.' },
                      { label: 'Tincan Heart', price: 360, img: '../assets/photos/canheart.jpg', description: 'A heart‑shaped tin ube cake, sweet and thoughtful in its presentation. With its tender texture and charming design, it’s an ideal way to show care and celebrate special occasions.' }
                    ],
                    true
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>

                            <div class="variant-box">
                                <img src="../assets/photos/messycup.jpg" alt="Messy Cup">
                                <span class="variant-price">₱70</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Messy Cup',
                    'Single‑serve ube messy cup, soft and moist with rich yam flavor.',
                    '../assets/photos/messycup.jpg',
                    [
                      { label: 'Messy Cup', price: 70, img: '../assets/photos/messycup.jpg', description: 'A single‑serve ube messy cup, soft and moist with a rich yam flavor. Perfect for a quick treat, it’s a convenient way to enjoy the classic taste of purple yam anytime.' }
                    ],
                    false
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="brazo" class="category-section" style="display:none;">
                <div class="spots-grid">
                    <div class="spot-card">
                        <h3>UBE BRAZO DE MERCEDES</h3>
                        <p>Meringue roll filled with creamy ube custard. Soft, sweet, and nostalgic.</p>
                        <div class="variant-row">
                            <div class="variant-box">
                                <img src="../assets/photos/tallbrazo.jpg" alt="Tall">
                                <span class="variant-price">₱100</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Ube Brazo de Mercedes',
                    'Meringue roll filled with creamy ube custard. Soft, sweet, and nostalgic.',
                    '../assets/photos/tallbrazo.jpg',
                    [
                      { label: 'Tall', price: 100, img: '../assets/photos/tallbrazo.jpg', description: 'A tall roll filled with creamy ube custard, soft and sweet with a nostalgic flavor. Perfect for sharing at family gatherings or enjoying as a centerpiece dessert.' },
                      { label: 'Small', price: 55, img: '../assets/photos/cakesabaso1.jpg', description: 'A small roll of ube brazo de mercedes, light and chewy with a rich custard filling. Ideal for individual servings, it’s a delightful treat for a quick indulgence.' }
                    ],
                    true
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="choco" class="category-section" style="display:none;">
                <div class="spots-grid">
                    <div class="spot-card">
                        <h3>CHOCO MOIST</h3>
                        <p>Rich chocolate base topped with creamy swirled frosting. Perfect for chocoholics!</p>
                        <div class="variant-row">
                            <div class="variant-box">
                                <img src="../assets/photos/cake4.jpg" alt="Choco Moist">
                                <span class="variant-price">₱730–₱1,150</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Choco Moist Cake',
                    'Rich chocolate base topped with creamy swirled frosting. Perfect for chocoholics!',
                    '../assets/photos/cake4.jpg',
                    [
                      { label: 'Large', price: 1150, img: '../assets/photos/cake4.jpg', description: 'A large choco moist cake, rich and indulgent with a soft chocolate base and creamy frosting. Perfect for big celebrations, it’s designed to satisfy a crowd of chocoholics with every slice.' },
                      { label: 'Medium', price: 730, img: '../assets/photos/mediumchoco.jpg', description: 'A medium‑sized choco moist cake, offering the same decadent flavor in a more compact size. Ideal for smaller gatherings or intimate occasions, it delivers just the right amount of sweetness to share.' }
                    ],
                    true
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>

                            <div class="variant-box">
                                <img src="../assets/photos/roundchoco.jpg" alt="Choco Moist">
                                <span class="variant-price">₱530</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Choco Moist Cake',
                    'Rich chocolate base topped with creamy swirled frosting. Perfect for chocoholics!',
                    '../assets/photos/roundchoco.jpg',
                    [
                      { label: 'Round', price: 530, img: '../assets/photos/roundchoco.jpg', description: 'A round choco moist cake, baked to perfection with a soft chocolate base and creamy frosting. Its classic style makes it a timeless choice for birthdays, gatherings, or everyday indulgence.' },
                      { label: 'Heart-shaped', price: 530, img: '../assets/photos/cake2.jpg', description: 'A heart‑shaped choco moist cake, rich and decadent with a swirl of frosting. Perfect for sharing love and sweetness, it’s a thoughtful centerpiece for romantic occasions or celebrations..' }
                    ],
                    true
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>

                            <div class="variant-box">
                                <img src="../assets/photos/cakesalata5.jpg" alt="Choco Moist Tincan">
                                <span class="variant-price">₱380–₱410</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Choco Moist Cake (Tincan)',
                    'Rich chocolate cake in compact tin containers, perfect for gifting or sharing.',
                    '../assets/photos/cakesalata5.jpg',
                    [
                      { label: 'Tincan Round', price: 380, img: '../assets/photos/cakesalata5.jpg', description: 'A round tin choco moist cake, compact and classic in presentation. Easy to gift and convenient to carry, it delivers the same indulgent flavor in a neat package.' },
                      { label: 'Tincan Heart', price: 410, img: '../assets/photos/chocoheart.jpg', description: 'A heart‑shaped tin choco moist cake, sweet and thoughtful in design. With its tender texture and charming look, it’s ideal for showing care or celebrating special milestones.' }
                    ],
                    true
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>

                            <div class="variant-box">
                                <img src="../assets/photos/messychoco.jpg" alt="Messy Cup">
                                <span class="variant-price">₱85</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Choco Moist Messy Cup',
                    'Single‑serve choco moist cup, rich and indulgent for a quick treat.',
                    '../assets/photos/messychoco.jpg',
                    [
                      { label: 'Messy Cup', price: 85, img: '../assets/photos/messychoco.jpg', description: 'A single‑serve choco moist cup, rich and indulgent for chocolate lovers. Perfect for a quick treat, it’s a convenient way to enjoy decadence anytime.' }
                    ],
                    false
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="custard" class="category-section" style="display:none;">
                <div class="spots-grid">
                    <div class="spot-card">
                        <h3>UBE CUSTARD CAKE</h3>
                        <p>Velvety ube sponge layered with golden custard. A Filipino classic reimagined.</p>
                        <div class="variant-row">
                            <div class="variant-box">
                                <img src="../assets/photos/ubecustard.jpg" alt="Round">
                                <span class="variant-price">₱490</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Ube Custard Cake',
                    'Velvety ube sponge layered with golden custard. A Filipino classic reimagined.',
                    '../assets/photos/ubecustard.jpg',
                    [
                      { label: 'Round', price: 490, img: '../assets/photos/ubecustard.jpg', description: 'A round ube custard cake, velvety and moist with layers of golden custard. A Filipino classic reimagined, it’s perfect for sharing at family gatherings or festive occasions.' },
                      { label: 'Slice', price: 70, img: '../assets/photos/ubecustardtriangle.jpg', description: 'A slice of ube custard cake, soft and flavorful with a creamy custard layer. Ideal for a quick treat, it offers a taste of tradition in every bite.' }
                    ],
                    true
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="creamcheese" class="category-section" style="display:none;">
                <div class="spots-grid">
                    <div class="spot-card">
                        <h3>UBE CREAMCHEESE BAR</h3>
                        <p>Ube bar topped with rich cream cheese swirl. Sweet, tangy, and satisfying.</p>
                        <div class="variant-row">
                            <div class="variant-box">
                                <img src="../assets/photos/purplebrownie.jpg" alt="Ube Creamcheese Bars">
                                <span class="variant-price">₱23–₱545</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Ube Creamcheese Bars',
                    'Delicious ube bars topped with creamcheese, available by slice or box of 16.',
                    '../assets/photos/purplebrownie.jpg',
                    [
                      { label: 'Box of 16', price: 545, img: '../assets/photos/purplebrownie.jpg', description: 'Perfect for sharing — 16 pieces of ube creamcheese bars, each topped with a rich swirl of cream cheese. Sweet, tangy, and satisfying, this box is great for parties or gifts.' },
                      { label: 'Slice', price: 23, img: '../assets/photos/creamcheese1.jpg', description: 'A single slice of ube creamcheese bar, chewy and flavorful with a creamy topping. Ideal for a quick treat, it’s a delightful way to enjoy ube in smaller portions.' }
                    ],
                    true
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="calamansi" class="category-section" style="display:none;">
                <div class="spots-grid">
                    <div class="spot-card">
                        <h3>UBE CALAMANSI BAR</h3>
                        <p>A zesty twist on ube — tangy calamansi meets creamy purple yam in a chewy bar.</p>
                        <div class="variant-row">
                            <div class="variant-box">
                                <img src="../assets/photos/ubecalamansi.jpg" alt="Ube Calamansi Bars">
                                <span class="variant-price">₱20–₱475</span>
                                <button class="details-btn" onclick="openProductModal(
                    'Ube Calamansi Bars',
                    'Tangy calamansi blended with sweet ube in chewy bars, available by slice or box of 16.',
                    '../assets/photos/ubecalamansi.jpg',
                    [
                      { label: 'Box of 16', price: 475, img: '../assets/photos/ubecalamansi.jpg', description: 'Perfect for sharing — 16 pieces of ube calamansi bars, blending tangy citrus with sweet purple yam. Chewy and refreshing, they’re a unique twist on a Filipino favorite.' },
                      { label: 'Slice', price: 20, img: '../assets/photos/ubecalamansi2.jpg', description: 'A single slice of ube calamansi bar, zesty and sweet with a chewy texture. Ideal for a quick treat, it’s a vibrant way to enjoy ube with a citrus kick.' }
                    ],
                    true
                  )">
                                    VIEW DETAILS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div id="productModal" class="modal">
        <div class="modal-content featured-layout">
            <span class="close-btn" onclick="closeModalById('productModal')">&times;</span>

            <div class="modal-body">
                <img id="modal-img" src="" alt="Product" class="modal-img-side">

                <div class="modal-info">
                    <h3 id="modal-title">Purple Yam Cake</h3>

                    <p id="action-price" class="modal-price">₱920</p>

                    <p id="modal-description" class="modal-description"></p>

                    <div class="quantity-row">
                        <label for="quantity">Qty:</label>
                        <button onclick="adjustQuantity(-1)">−</button>
                        <input type="number" id="quantity" value="1" min="1" onchange="updatePrice()">
                        <button onclick="adjustQuantity(1)">+</button>
                    </div>

                    <div id="type-buttons" class="type-selector"></div>
                    <div class="action-buttons">
                        <button class="order-btn" onclick="redirectToOrderPage()">ORDER NOW</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <section id="about" class="why">
        <h2>Why Choose Purple Yam?</h2>
        <div class="reasons">
            <div class="reason">
                <h3>Fresh Daily</h3>
                <p>All our cakes are baked fresh every day</p>
            </div>
            <div class="reason">
                <h3>Premium Quality</h3>
                <p>Only the finest ingredients used</p>
            </div>
            <div class="reason">
                <h3>Fast Delivery</h3>
                <p>Quick and reliable delivery service</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="about">
                <h3>Purple Yam</h3>
                <p>Delicious cakes and pastries made with love and the finest ingredients.</p>
            </div>
            <div class="links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="contact">
                <h4>Contact Info</h4>
                <p>Email: purpleyamargao@.com</p>
                <p>Phone: (123) 456-7890</p>
                <p>Address: Poblacion Argao, Cebu</p>
            </div>
        </div>
        <p class="footer-bottom">© 2025 Purple Yam Bakeshop. All rights reserved.</p>
    </footer>

    <div id="loginModal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="loginTitle">
        <div class="modal-content" role="document">
            <img src="../assets/logo.png" alt="Purple Yam Logo">
            <button class="close" aria-label="Close login dialog">&times;</button>

            <form class="login-form" id="loginForm">
                <p>Sign in to continue ordering your favorite treats!</p>

                <div class="form-group">
                    <input type="email" id="index-login-email" name="email" placeholder="Email" required />
                </div>

                <div class="form-group">
                    <input type="password" id="index-login-password" name="password" placeholder="Password" required />
                </div>

                <button type="submit" class="btn">Login</button>

                <p class="signup-links">
                    Don't have an account? <a href="#" class="signup-trigger">Sign in here</a>
                </p>
            </form>
        </div>
    </div>

    <div id="signupModal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="signupTitle">
        <div class="modal-content" role="document">
            <img src="../assets/logo.png" alt="Purple Yam Logo">
            <button class="close-signup" aria-label="Close sign up dialog">&times;</button>

            <form class="signup-form" id="signupForm">
                <p>Join us and enjoy delicious cakes and pastries!</p>

                <div class="form-group">
                    <input type="text" id="index-signup-firstname" name="firstname" placeholder="Firstname" required
                        autocomplete="firstname">
                </div>

                <div class="form-group">
                    <input type="text" id="index-signup-lastname" name="lastname" placeholder="Lastname" required
                        autocomplete="lastname">
                </div>

                <div class="form-group">
                    <input type="text" id="index-signup-contact" name="contact" placeholder="Phone" required
                        autocomplete="contact number">
                </div>

                <div class="form-group">
                    <input type="email" id="index-signup-email" name="email" placeholder="Email" required
                        autocomplete="email">
                </div>

                <div class="form-group">
                    <input type="password" id="index-signup-password" name="password" placeholder="Password" required
                        autocomplete="new-password">
                </div>

                <div class="form-group">
                    <input type="password" id="index-signup-confirm-password" name="confirm"
                        placeholder="Confirm password" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn">Sign Up</button>

                <p class="signup-links">
                    Already have an account? <a href="#" class="login-trigger">Login here</a>
                </p>
            </form>
        </div>
    </div>

    <div id="storesModal" class="modal" aria-hidden="true" role="dialog">
        <div class="modal-content" role="document">
            <button class="close" aria-label="Close stores dialog">&times;</button>
            <div id="stores-container">
                <section class="store-list">
                    <h2>CEBU BRANCHES</h2>
                    <div class="store-card" onclick="openMap('argao')">
                        <h3>PURPLE YAM - ARGAO</h3>
                        <p>12 San Miguel St, Poblacion, Argao, 6021 Cebu</p>
                    </div>
                    <div class="store-card" onclick="openMap('carcar')">
                        <h3>PURPLE YAM - CARCAR CITY</h3>
                        <p>4J6W+636, Carcar, Cebu</p>
                    </div>
                    <div class="store-card" onclick="openMap('cebu')">
                        <h3>PURPLE YAM - CEBU CITY</h3>
                        <p>Punta Princesa, 65 Francisco Llamas St, Cebu City, 6014 Cebu</p>
                    </div>
                    <div class="store-card" onclick="openMap('cordova')">
                        <h3>PURPLE YAM - CORDOVA</h3>
                        <p>BangBang, Cordova, Cebu</p>
                    </div>
                    <div class="store-card" onclick="openMap('dalaguete')">
                        <h3>PURPLE YAM - DALAGUETE</h3>
                        <p>Dalaguete, Cebu</p>
                    </div>
                    <div class="store-card" onclick="openMap('gallery')">
                        <h3>PURPLE YAM (THE GALLERY)</h3>
                        <p>8WF5+JMV, Pope John Paul II Ave, Cebu City, 6000 Cebu</p>
                    </div>
                    <div class="store-card" onclick="openMap('oslob')">
                        <h3>PURPLE YAM - OSLOB OUTLET</h3>
                        <p>Eternidad St, Poblacion, Oslob, 6025 Cebu</p>
                    </div>
                    <div class="store-card" onclick="openMap('talisay')">
                        <h3>PURPLE YAM - TALISAY</h3>
                        <p>South Agora, Deiparine St, San Isidro Road, Talisay, 6045 Cebu</p>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div id="mapModal" class="map-overlay">
        <div class="map-content">
            <span class="close-btn" onclick="closeMap()">&times;</span>
            <img id="mapImage" src="" alt="Store Map">
        </div>
    </div>

    <script src="../javascripts/account.js" defer></script>
</body>

</html>