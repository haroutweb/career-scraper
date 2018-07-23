import header from './components/header';
import bar from './components/bar';
import viewContent from './components/content';
import VueResource from 'vue-resource';

Vue.use(VueResource);

var app = new Vue({
    el: '#app',
    data: {
        msg: 'test message',
        viewUrl: '/jobs/view/',
        viewData: null,
        viewLoading: false
    },
    components: {
        headerComp: header,
        bar: bar,
        viewContent: viewContent
    },
    methods: {
        processViewData: function (id) {
            this.viewLoading = true;

            this.$http.get(this.viewUrl + id)
                .then(res => res.json())
                .then(res => {
                    this.viewData = res.data;

                    this.viewLoading = false;
                })
        }
    },
    template: `<div>
                    <headerComp/>
                    <div class="row">
                        <bar v-on:viewData="processViewData"/>
                        <div v-if="viewLoading"></div>
                        <viewContent v-bind:data="viewData" v-if="viewData"/>
                        <div class="clearFix"></div>
                    </div>
                </div>`
});