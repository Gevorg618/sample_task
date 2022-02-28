<template>
    <div>
        <v-dialog
            v-model="dialog"
            persistent
            max-width="600px"
        >
            <v-card>
                <v-card-title>
                    <span class="text-h5">Add Card</span>
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
                                    v-model="card.title"
                                ></v-text-field>
                                <span class="text-danger">{{ errors.first('title') }}</span>
                            </v-col>
                            <v-col
                                cols="12">
                                <v-text-field
                                    v-validate="'required'"
                                    name="desc"
                                    v-model="card.description"
                                    label="Description"
                                ></v-text-field>
                                <span class="text-danger">{{ errors.first('desc') }}</span>
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
                        :loading="loading"
                        color="blue darken-1"
                        text
                        @click="addCard"
                    >
                        Add a card
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>

</template>

<script>
export default {
    name: "addCard",
    data() {
        return {
            dialog: false,
            item: {
                title: '',
                description: ''
            },
            loading: false,
            card: {
                title: '',
                description: ''
            },
        }
    },
    methods: {
        async update() {
            this.loading = false;
            this.card.columnId = this.item.id;
            let response = await this.$store.dispatch('update', this.card)
            alert.$emit('alert', response)
            this.dialog = false
            if(response.success) this.$store.dispatch('getAll')
        },
        async addCard() {
            this.loading = false;
            this.card.column_id = this.item.id;
            let response = await this.$store.dispatch('addCard', this.card)
            this.dialog = false
            this.card.title = '';
            this.card.description = '';
            alert.$emit('alert', response)
            if(response.success) this.$store.dispatch('getAll')
        }
    },
    created() {
        alert.$on('update_item', data => {
            this.item = data
            this.dialog = true
        })
    }
}
</script>
