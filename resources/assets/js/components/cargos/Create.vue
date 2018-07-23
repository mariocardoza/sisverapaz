<template lang="html">

  			<div class="panel panel-primary">
  				<div class="panel-heading">Registro de cargos
          </div>
  				<div class="panel-body">
            <form class="form-horizontal" method="post">

            <div class="form-group">
                <label for="cargo" class="col-md-4 control-label">Nombre</label>

                <div class="col-md-6">
                    <input type="text" v-model="cargo.cargo" name="cargo" class="form-control">
                </div>
            </div>

  					<div class="form-group">
  						<div class="col-md-6 col-md-offset-4">
  							<button type="button" @click="crearCargo()" class="btn btn-success">
  								<span class="glyphicon glyphicon-floppy-disk">Registrar</span>
  							</button>
  						</div>
            </div>
            </form>

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
      cargos: []
    }
  },

  methods: {
    crearCargo(){
      axios.post("cargos" , {
        cargo:this.cargo.cargo,
      })
      .then(response => {
        this.cargos.push(response.data.cargo);
        toastr.success('Cargo registrado con éxito');
        this.reset();
      })
      .catch(error => {
        this.errors = [];
        console.log(error.response.data.errors.cargo);
        if(error.response.data.errors){
          toastr.error(error.response.data.errors.cargo);
        }
      });
    },

    reset(){
      this.cargo.cargo = '';
    }
  }
}
</script>

<style lang="css">
</style>
