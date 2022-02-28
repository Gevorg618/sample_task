<template>
    <v-card
        class="mx-auto mt-4"
        max-width="374"
        :key="item.id"
        :ref="item.id"
    >
        <template slot="progress">
            <v-progress-linear
                color="deep-purple"
                height="10"
                indeterminate
            ></v-progress-linear>
        </template>

        <v-img
            height="250"

            src="https://play-lh.googleusercontent.com/CiGs15N1e1tXrSnVLEY9jOnKi1oNzPQNRjqhR8fXE0pnu_bRyNmfc8xXr2VQUJTfJ9A"
        ></v-img>

        <v-card-title>{{item.title}}</v-card-title>

        <v-card-text>
            <v-row
                align="center"
                class="mx-0"
            >
                <v-rating
                    :value="4.5"
                    color="amber"
                    dense
                    half-increments
                    readonly
                    size="14"
                ></v-rating>
            </v-row>
        </v-card-text>

        <v-divider class="mx-4"></v-divider>

        <v-card-title>Tonight's availability</v-card-title>

        <v-card-text>
            <v-chip-group
                active-class="deep-purple accent-4 white--text"
                column
            >

                <draggable
                    :list="item.cards"
                    class="list-group"
                    ghost-class="ghost"
                    @start="dragging = true"
                    @end="dragging = false"
                    @change="updateListCardsSortOrderIndexColumn(item)"
                    group="items">
                    <v-chip
                        v-for="element in item.cards"
                        v-on:click="show(element)"
                        :key="element.id">
                        {{ element.title }}
                    </v-chip>
                </draggable>
            </v-chip-group>
        </v-card-text>

        <v-card-actions>
            <v-btn
                color="deep-purple lighten-2"
                text
                @click="remove">
                Remove
            </v-btn>
            <v-btn
                color="deep-purple lighten-2"
                text
                @click="update">
                Add a card
            </v-btn>
        </v-card-actions>
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
            show : function(showItem) {
                this.$root.$emit('OPEN_CARD_MODAL', {
                    showItem: showItem,
                });
            },
            async remove() {
                this.loading = true;
                let response = await this.$store.dispatch('remove', this.item.id)
                alert.$emit('alert', response)
                if(response.success) this.$store.dispatch('getAll')
                this.loading = false;
            },
            update() {
                alert.$emit('update_item', this.item)
            },
            async changeCard(){
                console.log('changeCard')
            },
            checkMove: function(e) {
                window.console.log("Future index: " + e.draggedContext.futureIndex, this.item.cards);
                console.log('checkMove: function', e)
            },
            // this method is run on the @change event:
            updateListCardsSortOrderIndexColumn(moved) {
                let newList = [...this.item.cards].map((item, index) => {
                    let newSort = index + 1;
                    item.hasChanged = item.index_column !== newSort;
                    if (item.hasChanged) {
                        item.index_column = newSort;
                    }
                    return item;
                });
                this.item.cards = newList;
                this.$store.dispatch('updateListColumns', this.items, this.item.id)
            },
        },
    }
</script>
