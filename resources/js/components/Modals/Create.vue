<template>
    <div>
        <v-dialog
            v-model="dialog"
            persistent
            max-width="600px"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="primary"
                    dark
                    v-bind="attrs"
                    v-on="on">
                    Add Column
                </v-btn>
                <v-btn
                    color="primary"
                    class="ml-4"
                    dark
                    @click="exportDB">
                    Export
                </v-btn>
            </template>

            <v-card>
                <v-card-title>
                    <span class="text-h5">Add Column</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col
                                cols="12">
                                <v-text-field
                                    label="Title"
                                    name="title"
                                    v-validate="'required'"
                                    v-model="params.title"
                                ></v-text-field>
                                <span class="text-danger">{{ errors.first('title') }}</span>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="blue darken-1"
                        text
                        @click="dialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="create"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>

</template>

<script>
export default {
    name: "Create",
    data() {
        return {
            dialog: false,
            params: {
                title: '',
            }
        }
    },
    methods: {
        async create() {
            let validate = await this.$validator.validateAll()
            if(validate) {
                let response = await this.$store.dispatch('create', this.params)
                if(response.success) {
                    alert.$emit('alert', response)
                    this.dialog = false;
                    this.params.title = '';
                    this.$store.dispatch('getAll')
                }
            }
        },

        async exportDB() {
            let response = await this.$store.dispatch('exportDB', this.params)
            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = "dump.sql";
            link.click();
        }
    }
}
</script>
