<template>
      <div class="panel panel-primary">
        <div class="panel-heading">Listado de cargos
        </div>
        <div class="panel-body table-responsive">
          <table class="table table-striped table-bordered table-hover" id="example2">
            <thead>
              <tr>
                <th>N°</th>
                <th>Cargo</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(cargo, index) in cargos">
                <td>{{index+1}}</td>
                <td>{{cargo.cargo}}</td>
                <td>
                  <button type="button" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
</template>

<script>
  export default {
    data(){
      return {
        cargo: {
          cargo: ''
        },
        errors: [],
        cargos: [],
        update_cargo: {}
      }
    },

    mounted()
    {
      this.listarCargos();
    },

    methods: {
      listarCargos(){
        axios.get('cargos/get')
        .then(response => {
          this.cargos = response.data.cargos
        });
      },

      crearForm(){

      }
    }

}
</script>
