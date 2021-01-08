<template>
    <div class="container">
        <br/>
        <div>
            <select class="custom-select" style="width: 80px;" v-model="currency">
                <option value="1">EUR</option>
                <option value="0">USD</option>
            </select>
        </div>
        <Cart v-bind:items="this.items" v-bind:currency="this.currencyInt"></Cart>
        <div class="row">
            <div v-for="product in products" :key="product.id">
                <div class="card col-sm m-2" style="width: 22rem;">
                    <img :src="product.image" class="card-img-top" alt="">
                    <div class="card-title">
                        <h2 class="card-title"> {{ product.name }} </h2>
                        <p class="card-text">{{ product.description }}</p>
                        <h1 class="card-title">{{ product.price[currencyInt].value }}
                            {{ product.price[currencyInt].currency.name }}</h1>
                        <a class="btn btn-primary" style="width: 19rem;"
                           v-on:click="addProductToCart(product)">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Cart from "./Cart";

export default {
    props: ['userName'],
    data() {
        return {
            products: [],
            items: [], //JSON.parse(localStorage.items),
            currency: 0, //default currency
        }
    },
    created() {
        this.axios
            .get('/api/products')
            .then(response => {
                this.products = response.data;
            });

        if (this.$cookies.get('orderok') === '1') {
            this.$cookies.set('orderok','0')
            this.$toast("Thank you for your purchase", {position: 'bottom-right'});
        }
    },
    components: {
        Cart
    },
    methods: {
        addProductToCart: function (product) {
            //Notification
            this.$toast("Pizza " + product.name + " added to Cart", {position: 'bottom-right'});

            //Check already added ID
            for (const [key, value] of Object.entries(this.items)) {
                if (value.id === product.id) {
                    value.amount = value.amount + 1;
                    return;
                }
            }

            this.items.push({
                id: product.id,
                name: product.name,
                amount: 1,
                currency: {
                    0: {
                        value: product.price[0].value,
                        name: product.price[0].currency.name
                    },
                    1: {
                        value: product.price[1].value,
                        name: product.price[1].currency.name
                    }
                }
            });

            localStorage.items = JSON.stringify(this.items);
            document.cookie = "items="+ JSON.stringify(this.items) + ";path=/";
        }
    },
    computed: {
        currencyInt: function () {
            return parseInt(this.currency, 10)
        }
    }
}


</script>

<style scoped>

</style>
