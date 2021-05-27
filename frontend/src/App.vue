<template>
  <div id="app">
    <input type="text"
           placeholder="Search products by name, description or brand"
           v-model="filter" />
    <p v-if="errors.length">
      <b>Please correct the following error(s):</b>
      <ul>
        <li v-for="(error, index) in errors" :key="`error-${index}`">{{ error }}</li>
      </ul>
    </p>

    <form ref="addProduct" @submit.prevent="addProduct">
      <table>
        <tbody>
        <tr>
          <td><input type="text" placeholder="Product id" v-model="newProduct['product_id']"/></td>
          <td><input type="text" placeholder="Name" v-model="newProduct['name']"/></td>
          <td><input type="text" placeholder="Description" v-model="newProduct['description']"/></td>
          <td><input type="text" placeholder="Brand" v-model="newProduct['brand']"/></td>
          <td><input type="text" placeholder="Price" v-model="newProduct['price']"/></td>
          <td><input type="text" placeholder="Stock" v-model="newProduct['stock']"/></td>
        </tr>
        <tr>
          <td :colspan="7"><button>Add product</button></td>
        </tr>
        </tbody>
      </table>
    </form>

    <br />
    <table>
      <thead>
      <tr>
        <th v-for="(column, index) in columns" :key="`column-${index}`">{{ column }}</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(row, index) in filteredRows" :key="`product-${index}`">
        <td v-html="row.product_id"></td>
        <td v-html="highlightMatches(row.name)"></td>
        <td v-html="highlightMatches(row.description)"></td>
        <td v-html="highlightMatches(row.brand)"></td>
        <td v-html="row.price"></td>
        <td v-html="row.stock"></td>
        <td><button @click="deleteProduct(row.id)">Delete</button></td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    filter:'',
    columns: ['Product_id', 'Name', 'Description', 'Brand', 'Price', 'Stock', 'Actions'],
    newProduct: {...{'id': '','product_id': '', 'name': '', 'description': '', 'brand': '', 'price': '', 'stock': ''}},
    rows: [],
    errors: [],
  }),
  created:function() {
    fetch('http://localhost:8000/api/products?api_token=' + process.env.VUE_APP_API_TOKEN)
        .then(res => res.json())
        .then(res => {
          this.rows = res;
        })
  },
  methods: {
    addProduct(e) {
      if (
          this.newProduct.product_id
          && this.newProduct.name
          && this.newProduct.description
          && this.newProduct.brand
          && this.newProduct.price
          && this.newProduct.stock
      ) {
        let currentObj = this;
        axios.post("http://localhost:8000/api/products?api_token=" + process.env.VUE_APP_API_TOKEN , {
          product_id: this.newProduct.product_id,
          name: this.newProduct.name,
          description: this.newProduct.description,
          brand: this.newProduct.brand,
          price: this.newProduct.price,
          stock: this.newProduct.stock
        }).then(function (response) {
          currentObj.rows.push({...{
              'id': response.data.id,
              'product_id': response.data.product_id,
              'name': response.data.name,
              'description': response.data.description,
              'brand': response.data.brand,
              'price': response.data.price,
              'stock': response.data.stock
          }})
        });
        this.newProduct = {...{'id': '','product_id': '', 'name': '', 'description': '', 'brand': '', 'price': '', 'stock': ''}};
        return;
      }

      this.errors = [];

      // Just required validation. We could add more, to check integer, to check for duplicated, check brand exists etc
      if (!this.newProduct.product_id) {
        this.errors.push('Product id required.');
      }
      if (!this.newProduct.name) {
        this.errors.push('Name required.');
      }
      if (!this.newProduct.description) {
        this.errors.push('Description required.');
      }
      if (!this.newProduct.brand) {
        this.errors.push('Brand required.');
      }
      if (!this.newProduct.price) {
        this.errors.push('Price required.');
      }
      if (!this.newProduct.stock) {
        this.errors.push('Stock required.');
      }

      e.preventDefault();

    },
    deleteProduct(id) {
      if(confirm("Do you really want to delete?")){

        this.rows = this.rows.filter(obj => {
          return obj.id !== id
        });

        axios.delete("http://localhost:8000/api/products/" + id + "?api_token=" + process.env.VUE_APP_API_TOKEN)
      }
    },
    highlightMatches(text) {
      const matchExists = text.toLowerCase().includes(this.filter.toLowerCase());
      if (!matchExists) return text;

      const re = new RegExp(this.filter, 'ig');
      return text.replace(re, matchedText => `<strong>${matchedText}</strong>`);
    }
  },
  computed: {
    filteredRows() {
      return this.rows.filter(row => {
        const names = row.name.toLowerCase();
        const descriptions = row.description.toLowerCase();
        const brands = row.brand.toLowerCase();
        const searchTerm = this.filter.toLowerCase();

        return names.includes(searchTerm) ||
            descriptions.includes(searchTerm) ||
            brands.includes(searchTerm);
      });
    },
  },
};
</script>

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

th {
  background-color: #dddddd;
}

input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0 25px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
