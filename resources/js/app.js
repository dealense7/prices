import './bootstrap';
import { Chart } from 'chart.js/auto'

import.meta.glob([
    '../imgs/**',
    '../fonts/**',
]);

window.productCartIds = [];
let myChart;

window.paintChart = async (id) => {
    fetch(
        'api/product/' + id + '/price-history',
        {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(res => {
            let ctx = document.getElementById('myChart');
            const labels = res.weeks;
            let data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Max',
                        data: res.max_prices,
                        fill: false,
                        borderColor: 'rgb(255,40,61)',
                        tension: 0.1
                    },
                    {
                        label: 'Min',
                        data: res.min_prices,
                        fill: false,
                        borderColor: 'rgb(54,189,128)',
                        tension: 0.1
                    }
                ]
            };
            let config = {
                type: 'line',
                data: data,
            };
            if (myChart) {
                // Update the existing chart's data
                myChart.data.labels = labels;
                myChart.data.datasets[0].data = res.max_prices;
                myChart.data.datasets[1].data = res.min_prices;
                myChart.update(); // Update the chart
            } else {
                // Create a new chart instance
                let config = {
                    type: 'line',
                    data: data,
                };
                myChart = new Chart(ctx, config); // Store the chart instance
            }
        })
}
const fetchPrice = async (items) => {

    if (items.length < 1) {
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

            document.getElementById('totalPriceCart').innerHTML = (lowestSum / 100).toFixed(2)
            document.getElementById('totalPriceCartModal').innerHTML = (lowestSum / 100).toFixed(2)
            document.getElementById('totalProducts').innerHTML = 'რაოდენობა: ' + items.length

            if ((highestSum - lowestSum) > 1) {
                document.getElementById('totalSavedPriceCart').classList.remove('hidden')
                document.getElementById('totalSavedPriceCart').innerHTML = '- ' + ((highestSum - lowestSum) / 100).toFixed(2) + ' ₾'
                document.getElementById('totalSavedCartModal').innerHTML = '- ' + ((highestSum - lowestSum) / 100).toFixed(2) + ' ₾'
            }
        })

    return fetchedItems;
}


window.cartItems = () => {
    return {
        items: [],
        async getItems() {
            const storedValue = localStorage.getItem("itemIds");
            window.productCartIds = storedValue ? JSON.parse(storedValue) : [];

            window.productCartIds.forEach(item => {
                if (document.getElementById('addProductToCart' + item.id)) {
                    document.getElementById('addProductToCart' + item.id).classList.add('bg-green-400');
                }
            })

            if (window.productCartIds.length > 0) {
                document.getElementById('cartItemsCount').classList.remove('hidden');
                document.getElementById('cartItemsCount').innerHTML = window.productCartIds.length.toString();
                this.items = [...await fetchPrice(window.productCartIds)];
            } else {
                document.getElementById('cartItemsCount').classList.add('hidden');
                document.getElementById('totalPriceCartModal').innerHTML = '0.00 ₾'
                document.getElementById('totalSavedCartModal').innerHTML = '0.00 ₾'
                document.getElementById('totalProducts').innerHTML = 'რაოდენობა: 0'

                this.items = [];
            }

        }
    }
}

window.removeProduct = (id) => {
    removeFromLocalStorage(id)
    addClass(id)
}

window.addProduct = (id) => {
    addToLocalStorage(id)
    addClass(id)
}

window.toggleProduct = (id) => {
    let items = window.productCartIds;

    if (!items.some(item => item.id === id)) {
        addProduct(id);
    } else {
        removeProduct(id);
    }
}

const addClass = (id) => {
    if (document.getElementById('addProductToCart' + id)) {
        if (!document.getElementById('addProductToCart' + id).classList.contains('bg-green-400')
        ) {
            document.getElementById('addProductToCart' + id).classList.add('bg-green-400');
        } else {
            document.getElementById('addProductToCart' + id).classList.remove('bg-green-400');
        }
    }
}

const addToLocalStorage = (id) => {

    const items = [{id: id}, ...window.productCartIds]
    window.productCartIds = items;

    updateLocalStorage('itemIds', items);
    updateCart(items)
    fetchPrice(items)
}

const removeFromLocalStorage = (id) => {

    const items = window.productCartIds.filter(item => item.id !== id);
    window.productCartIds = items;

    updateLocalStorage('itemIds', items);
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

const updateLocalStorage = (name, items) => {
    localStorage.setItem(name, JSON.stringify(items));
}
