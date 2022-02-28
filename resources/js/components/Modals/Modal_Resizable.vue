<template>
    <modal
        id="resizable_id"
        :draggable="true"
        name="resizable"
        :min-width="200"
        :min-height="200"
        :resizable="true"
        styles="font-style: italic;"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Update Card</span>
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
                                v-model="showItem.title"
                            ></v-text-field>
                            <span class="text-danger">{{ errors.first('title') }}</span>
                        </v-col>
                        <v-col
                            cols="12">
                            <v-text-field
                                v-validate="'required'"
                                name="desc"
                                v-model="showItem.description"
                                label="Description"
                            ></v-text-field>
                            <span class="text-danger">{{ errors.first('desc') }}</span>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions class="justify-center d-flex">
                <v-btn
                    color="deep-purple lighten-2"
                    text
                    v-on:click="hide"
                >
                    Hide
                </v-btn>
                <v-btn
                    color="deep-purple lighten-2"
                    text
                    @click="updateCard"
                >
                    Update Card
                </v-btn>
            </v-card-actions>
        </v-card>
    </modal>
</template>
<script>
    export default {
        name: 'Modal_Resizable',
        data: () => ({
            showItem: {},
        }),
        methods: {
            hide() {
                this.$modal.hide('resizable');
            },
            updateCard() {
                const params = {
                    id: this.showItem.id,
                    title: this.showItem.title,
                    description: this.showItem.description,
                };
                this.$store.dispatch('updateCard', params);
                this.$modal.hide('resizable');
            },
        },
        computed: {
            items() {
                return this.$store.getters.getItems
            }
        },
        mounted() {
            this.$root.$on('OPEN_CARD_MODAL', data => {
                this.showItem = data.showItem
                this.$modal.show('resizable');
            });
        }
    }
</script>
