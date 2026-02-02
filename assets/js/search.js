document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('searchSuggestions');

    if (!searchInput || !suggestionsBox) return;

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();

        if (query.length < 2) {
            suggestionsBox.style.display = 'none';
            suggestionsBox.innerHTML = '';
            return;
        }

        fetch(`../public/search.php?ajax=1&q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                suggestionsBox.innerHTML = '';

                if (data.length > 0) {
                    suggestionsBox.style.display = 'block';
                    const list = document.createElement('ul');
                    list.style.listStyle = 'none';
                    list.style.padding = '0';
                    list.style.margin = '0';

                    data.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = item.product_name;
                        li.style.padding = '8px 12px';
                        li.style.cursor = 'pointer';
                        li.style.borderBottom = '1px solid #eee';

                        li.addEventListener('mouseover', () => {
                            li.style.backgroundColor = '#f9f9f9';
                        });
                        li.addEventListener('mouseout', () => {
                            li.style.backgroundColor = '#fff';
                        });

                        li.addEventListener('click', () => {
                            window.location.href = `search.php?q=${encodeURIComponent(item.product_name)}`;
                        });

                        list.appendChild(li);
                    });

                    suggestionsBox.appendChild(list);
                } else {
                    suggestionsBox.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
            });
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.style.display = 'none';
        }
    });
});
// USER ORDER ACTION
function orderPlaced() {
    alert("Order Placed Successfully");
}
let deleteForm = null;

function openDeleteModal(button) {
    deleteForm = button.closest('form');
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
    deleteForm = null;
    document.getElementById('deleteModal').style.display = 'none';
}

function confirmDelete() {
    if (deleteForm) {
        deleteForm.submit();
    }
}

// ORDER HANDLER

function placeOrder(productId) {
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'order_product_id=' + encodeURIComponent(productId)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('orderModal').style.display = 'flex';
        }
    })
    .catch(err => {
        console.error('Order failed', err);
    });
}

function closeOrderModal() {
    document.getElementById('orderModal').style.display = 'none';
}

