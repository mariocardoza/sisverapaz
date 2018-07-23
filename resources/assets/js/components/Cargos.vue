<template>
  <div class="row">
    <div class="col-md-12">
      <a href="#" @click="crearForm('Crear')" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
      <a href="#" @click="crearForm('Cargo')" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Listar</a>
    <hr>
      <transition name="fade">
        <component
            v-bind:is="currentView"
        />
      </transition>
    </div>
  </div>
</template>

<script>
  import Cargo from './cargos/Cargo.vue';
  import Crear from './cargos/Create.vue';
  export default {
    components: {
      Cargo, Crear
    },

    data(){
      return {
        components: ['cargo','crear'],
        currentView: 'cargo'
      }
    },
    methods:{
      crearForm(view){
        this.currentView = view;
      }
    }
  }
</script>

<style lang="css">
.fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
        display: none;
    }
    .fade-leave-active {
        opacity: 0.8
    }
</style>
