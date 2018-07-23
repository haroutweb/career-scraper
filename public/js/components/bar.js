import VueResource from 'vue-resource';

Vue.use(VueResource);

var bar = Vue.component('bar', {
    created: function () {
        this.getList();
    },
    methods: {
        getList: function () {
            this.$http.get('/jobs')
                .then(res => {
                    return res.json()
                })
                .then(res => {
                    this.list = res.data;
                    this.loading = false;
                })
        },
        selectItem: function (id) {
            this.activeItemId = id;

            this.$emit('viewData', id);
        }
    },
    data: () => {
        return {
            list: [],
            loading: true,
            activeItemId: 0
        }
    },
    template: `<div id="bar" class="col-sm-4">
                   <div class="row"> 
                       <div class="loader" v-if="loading">Loading ...</div>
                       <div class="bar-content" v-else>
                           <ul>
                               <li v-for="item in list" class="item" :class="{'active': activeItemId === item.id}">
                                   <span v-on:click="selectItem(item.id)" v-bind:data-id="item.id">{{ item.title }}</span>
                               </li>
                           </ul>
                       </div>
                   </div>
               </div>`
});

export default bar;