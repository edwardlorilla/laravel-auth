<template>
    <v-card>
        <v-card-text>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 sm6 md4>
                        <v-text-field v-model="create$.transaction_id" label="transaction"/>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field v-model="create$.amount" label="amount"/>
                    </v-flex>
                </v-layout>
            </v-container>
            <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click.native="store$">Save</v-btn>
        </v-card-actions>
    </v-card>
</template>
<script>
    export default{
        data(){
            return{
                msg:'hello vue'
            }
        }
    }
</script>
