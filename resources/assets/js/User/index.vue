<template>
    <v-dialog v-if="$root.$data.dialog" v-model="$root.$data.dialog" lazy max-width="500px">
        <edit-user/>
    </v-dialog>
</template>

<script>
    import EditUser from "./EditUser.vue";
    export default{
        components:{
            EditUser
        }
    }
</script>