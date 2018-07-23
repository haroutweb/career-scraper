import VueResource from 'vue-resource';

Vue.use(VueResource);

var viewContent = Vue.component('viewContent', {
    props: ['data'],
    template: `<div id="content" class="col-sm-8">
                   <div class="row">
                       <h2 class="text-primary">{{ data.title }}</h2>
                       <div class="company text-danger">{{ data.company }}</div>
                       <div class="description" v-html="data.content"></div>
                   </div>
               </div>`
});

export default viewContent;