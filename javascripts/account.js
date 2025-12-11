function openModalById(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden', 'false');
}

function closeModalById(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
}

document.querySelectorAll('.close, .close-signup, .close-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        const modal = e.target.closest('.modal');
        if (modal) {
            closeModalById(modal.id);
        }
    });
});

function openLoginModal() { openModalById('loginModal'); }
function openSignupModal() { openModalById('signupModal'); }

// --- Product Modal ---
let currentProduct = {};
let selectedPrice = 0;

function openProductModal(title, description, imgSrc, types = []) {
    currentProduct = { title, description, imgSrc, types };
    document.getElementById('modal-title').innerText = title;
    document.getElementById('modal-description').innerText = description;
    document.getElementById('modal-img').src = imgSrc;
    document.getElementById('quantity').value = 1;

    const container = document.getElementById('type-buttons');
    container.innerHTML = '';

    if (types.length > 0) {
        types.forEach(type => {
            const btn = document.createElement('button');
            btn.className = 'type-btn';
            btn.innerText = type.label;
            btn.onclick = () => selectType(type);
            container.appendChild(btn);
        });
        selectType(types[0]);
    } else {
        selectedPrice = 0;
        updatePrice();
    }

    openModalById('productModal');
}

function selectType(type) {
    selectedPrice = type.price;
    document.getElementById('modal-img').src = type.img;
    document.getElementById('modal-description').innerText = type.description;
    updatePrice();
    highlightSelectedType(type.label);
}

function updatePrice() {
    const qty = parseInt(document.getElementById('quantity').value) || 1;
    const total = selectedPrice * qty;
    document.getElementById('action-price').innerText = `₱${total}`;
}

function adjustQuantity(change) {
    const qtyInput = document.getElementById('quantity');
    let value = parseInt(qtyInput.value);
    value = Math.max(1, value + change);
    qtyInput.value = value;
    updatePrice();
}

function highlightSelectedType(label) {
    const buttons = document.querySelectorAll('.type-btn');
    buttons.forEach(btn => {
        btn.classList.toggle('active', btn.innerText === label);
    });
}

// --- Redirect to Order Page ---
function redirectToOrderPage() {
    const title = document.getElementById("modal-title").innerText;
    const price = parseFloat(document.getElementById("action-price").innerText.replace("₱", ""));
    const quantity = parseInt(document.getElementById("quantity").value);
    const variant = document.querySelector(".type-btn.active")?.innerText || "";

    const orderData = [{
        title: title,
        price: price,
        qty: quantity,
        type: variant
    }];
    
    sessionStorage.setItem("selectedOrder", JSON.stringify(orderData));
    alert("Redirect triggered!");

    window.location.href = "order.php";
}
