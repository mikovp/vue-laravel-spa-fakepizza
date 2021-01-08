<template>
    <div class="container">
        <div class="text-right">
            <a href="/home" class="btn btn-primary" role="button" v-text="authUser"></a>
            <button class="btn btn-primary" data-toggle="modal" data-target="#cartModal">
                <img src="images/cart.svg" width="20"/>
                Cart ({{ count }})
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="checkout-box">
                            <h2>Cart</h2>
                            <h1 v-if="!count">&#128683;&#127829;&#128580;</h1>
                            <table class="table" v-if="count">
                                <tbody>
                                <tr v-for="(item, index) in items">
                                    <th scope="row">Pizza</th>
                                    <td>{{ item.name }}</td>
                                    <td>
                                        <button class="btn btn-outline-secondary btn-sm" @click="minus(index)">-
                                        </button>
                                        {{ item.amount }}
                                        <button class="btn btn-outline-secondary btn-sm" @click="plus(index)">+</button>
                                    </td>
                                    <td>{{ item.currency[currency].value }}</td>
                                    <td>{{ item.currency[currency].name }}</td>
                                    <td>
                                        <button class="btn btn-outline-secondary btn-sm" @click="remove(index)">x
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Subtotal:</td>
                                    <td>{{ total }}</td>
                                    <td>{{ options[currency] }}</td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="/order" class="btn btn-primary" role="button" @click="saveOrder()" v-if="count">Proceed to Checkout</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

export default {
    name: "Cart",
    data() {
        return {
            options:
                {
                    0: 'USD',
                    1: 'EUR'
                }
        }
    },
    props: [
        'items',
        'currency'
    ],
    methods: {
        remove(index) {
            this.items.splice(index, 1)
        },
        plus: function (index) {
            for (const [key, value] of Object.entries(this.items)) {
                if (parseInt(key, 10) === index)
                    value.amount = value.amount + 1
            }
        },
        minus: function (index) {
            for (const [key, value] of Object.entries(this.items)) {
                if (parseInt(key, 10) === index)
                    if (value.amount > 1) {
                        value.amount = value.amount - 1
                    }

            }
        },
        saveOrder: function() {
            localStorage.items = JSON.stringify(this.items)

            document.cookie = "items="+ JSON.stringify(this.items) + ";path=/"
            document.cookie = "currency="+ this.currency + ";path=/"
        }
    },
    computed: {
        count: function () {
            let count = 0
            for (const [key, value] of Object.entries(this.items)) {
                count = count + value.amount
            }
            return count
        },
        total: function () {
            let total = 0
            for (const [key, value] of Object.entries(this.items)) {
                total = total + value.amount * value.currency[this.currency].value;
            }
            return total.toFixed(2)
        },
        authUser: function (){
            if (typeof this.$authUser != 'undefined') {
                return this.$authUser.name
            }
            return 'Sign in'
        }

    }

}

</script>

<style scoped>

</style>
