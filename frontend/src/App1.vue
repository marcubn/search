<template>
  <div id="app">

    <input type="search" v-model="filter">
    <table>
      <thead>
      <tr>
        <th @click="sort('name')">Name</th>
        <th @click="sort('age')">Age</th>
        <th @click="sort('breed')">Breed</th>
        <th @click="sort('gender')">Gender</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(cat, index) in sortedCats" :key="`cat-${index}`">
        <td>{{cat.name}}</td>
        <td>{{cat.age}}</td>
        <td>{{cat.breed}}</td>
        <td>{{cat.gender}}</td>
      </tr>
      </tbody>
    </table>
    <p>
      <button @click="prevPage">Previous</button>
      <button @click="nextPage">Next</button>
    </p>

    debug: sort={{currentSort}}, dir={{currentSortDir}}, page={{currentPage}}
  </div>
</template>

<script>

export default {
  data: () => ({
    cats:[],
    currentSort:'name',
    currentSortDir:'asc',
    pageSize:5,
    currentPage:1,
    filter:''
  }),
  created:function() {
    fetch('https://www.raymondcamden.com/.netlify/functions/get-cats')
        .then(res => res.json())
        .then(res => {
          this.cats = res;
        })
  },
  methods:{
    sort:function(s) {
      //if s == current sort, reverse
      if(s === this.currentSort) {
        this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
      }
      this.currentSort = s;
    },
    nextPage:function() {
      if((this.currentPage*this.pageSize) < this.filteredCats.length) this.currentPage++;
    },
    prevPage:function() {
      if(this.currentPage > 1) this.currentPage--;
    }

  },
  watch: {
    filter() {
      console.log('reset to p1 due to filter');
      this.currentPage = 1;
    }
  },
  computed: {
    filteredCats() {
      return this.cats.filter(c => {
        if(this.filter == '') return true;
        return c.name.toLowerCase().indexOf(this.filter.toLowerCase()) >= 0;
      })
    },
    sortedCats() {

      return this.filteredCats.sort((a,b) => {
        let modifier = 1;
        if(this.currentSortDir === 'desc') modifier = -1;
        if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
        if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
        return 0;
      }).filter((row, index) => {
        let start = (this.currentPage-1)*this.pageSize;
        let end = this.currentPage*this.pageSize;
        if(index >= start && index < end) return true;
      });
    }
  }
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
