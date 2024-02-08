import './bootstrap';

import.meta.glob([
    '../imgs/**',
    '../fonts/**',
]);

const fetchPrice = async (items) => {

    if (items.length < 1){
        document.getElementById('totalPriceCart').innerHTML = '0.00'

        document.getElementById('totalSavedPriceCart').classList.add('hidden')
        return;
    }

    const ids = items.map(item => item.id);

    const url = 'api/products';
    const queryString = `?ids[]=${ids.join('&ids[]=')}`;

    let fetchedItems = [];

    await fetch(
        url + queryString,
        {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(items => {
            fetchedItems = items;

            let lowestSum = 0;
            let highestSum = 0;

            items.map(value => {
                let prices = value.prices.map(item => item.price);
                lowestSum += Math.min(...prices);
                highestSum += Math.max(...prices);
            });

            document.getElementById('totalPriceCart').innerHTML = (lowestSum/100).toFixed(2)
            document.getElementById('totalPriceCartModal').innerHTML = (lowestSum/100).toFixed(2)
            document.getElementById('totalProducts').innerHTML = 'რაოდენობა: ' + items.length

            if ((highestSum - lowestSum) > 1)
            {
                document.getElementById('totalSavedPriceCart').classList.remove('hidden')
                document.getElementById('totalSavedPriceCart').innerHTML = '- ' + ((highestSum-lowestSum)/100).toFixed(2) +' ₾'
                document.getElementById('totalSavedCartModal').innerHTML = '- ' + ((highestSum-lowestSum)/100).toFixed(2) +' ₾'
            }
        })

    return fetchedItems;
}



window.cartItems = () => {
    return {
        items: [],
        async getItems() {
            this.items = [];

            const productCartIds = JSON.parse(localStorage.getItem("itemIds") ?? '{}');

            productCartIds.forEach(item => {
                document.getElementById('addProductToCart' + item.id).classList.add('bg-green-400');
            })

            if (productCartIds.length > 0) {
                document.getElementById('cartItemsCount').classList.remove('hidden');
                document.getElementById('cartItemsCount').innerHTML = productCartIds.length;
                this.items.push(...await fetchPrice(productCartIds));
            }

        }
    }
}



window.addProduct = (id) => {
    addToLocalStorage(id)
    addClass(id)
}

const addClass = (id) => {
    if (!document.getElementById('addProductToCart' + id).classList.contains('bg-green-400')) {
        document.getElementById('addProductToCart' + id).classList.add('bg-green-400');
    } else {
        document.getElementById('addProductToCart' + id).classList.remove('bg-green-400');
    }
}

const addToLocalStorage = (id) => {
    let items = JSON.parse(localStorage.getItem("itemIds")) ?? [];
    if (!items.some(item => item.id === id)) {
        items = [{id: id}, ...items]
        localStorage.setItem("itemIds", JSON.stringify(items));
    } else {
        items = items.filter(item => item.id !== id);
        localStorage.setItem("itemIds", JSON.stringify(items));
    }

    updateCart(items)
    fetchPrice(items)
}

const updateCart = (items) => {
    if (items.length > 0) {
        document.getElementById('cartItemsCount').classList.remove('hidden');
        document.getElementById('cartItemsCount').innerHTML = items.length;
    } else {
        document.getElementById('cartItemsCount').classList.add('hidden');
    }
}
