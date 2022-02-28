<template>
    <v-app>
        <v-container>
            <Create />
            <Update />
            <DemoResizableModal />
            <v-row>
                <v-col v-for="(item, key) in items" :key="key" cols="12" sm="6" md="3">
                    <Column :item="item" />
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
import Create from "../components/Modals/Create";
import Update from "../components/Modals/Update";
import DemoResizableModal from '../components/Modals/Modal_Resizable.vue'

export default {
    name: "App",
    components: {
        Create,
        Update,
        DemoResizableModal
    },
    computed: {
        items() {
            return this.$store.getters.getItems
        }
    },
    created() {
        this.$store.dispatch('getAll')
    }
}
</script>
