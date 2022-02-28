<template>
    <v-card
        outlined>
        <v-list-item three-line>
            <v-list-item-content>
                <v-list-item-title class="text-h5 mb-1">
                    {{item.title}}
                </v-list-item-title>
                <v-btn
                    :loading="loading"
                    rounded
                    depressed
                    @click="remove"
                    color="error"
                >
                    Remove
                </v-btn>
            </v-list-item-content>
        </v-list-item>

        <v-card-actions>
            <v-btn
                outlined
                rounded
                depressed
                @click="update"
                text
            >
                Add a card
            </v-btn>
        </v-card-actions>
        <draggable v-model="item.cards" group="people" @start="drag=true" @end="drag=false">
            <div v-for="card in cards" :key="card.id">{{card.title}} ===</div>
        </draggable>
    </v-card>
</template>

<script>
import draggable from 'vuedraggable'
export default {
    name: "Item",
    components: {
        draggable
    },
    data: () => ({
        loading: false,
    }),
    props: {
        item: {
            required: true
        }
    },
    computed: {
        items() {
            return this.$store.getters.getItems
        }
    },
    methods: {
        async remove() {
            let response = await this.$store.dispatch('remove', this.item.id)
            alert.$emit('alert', response)
            if(response.success) this.$store.dispatch('getAll')
        },
        update() {
            alert.$emit('update_item', this.item)
        }
    },
}
</script>
