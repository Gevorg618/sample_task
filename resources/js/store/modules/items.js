export default {
    state: {
        items: [],
        item: null
    },

    actions: {
        /**
         *
         * @param commit
         * @param state
         * @param params
         * @returns {Promise<boolean|*>}
         */
        async create({commit, state}, params) {
            try {
                let response = await axios.post('/api/columns', params)
                return response.data
            }
             catch (e) {
                return false
            }
        },

        async exportDB({commit, state}, params) {
            try {
                let response = await axios.post('/api/export')
                return response.data
            }
            catch (e) {
                return false
            }
        },

        async addCard({commit, state}, params) {
            try {
                let response = await axios.post('/api/cards', params)
                return response.data
            }
             catch (e) {
                return false
            }
        },

        /**
         *
         * @param commit
         * @param state
         * @returns {Promise<boolean>}
         */
        async getAll({commit, state}) {

            try {
                let response = await axios.get('/api/columns')
                commit('SET_ITEMS', response.data.items)

                return true
            }
            catch (e) {
                return false
            }
        },

        /**
         *
         * @param commit
         * @param state
         * @param id
         * @returns {Promise<boolean|any>}
         */
        async remove({commit, state}, id) {

            try {
                let response = await axios.delete(`/api/columns/${id}`)
                return response.data
            } catch (e) {
                return false
            }

        },

        /**
         *
         * @param commit
         * @param state
         * @param params
         * @returns {Promise<boolean|*>}
         */
        async updateCard({commit, state}, params) {

            try {
                let response = await axios.put(`/api/cards/${params.id}`, params)
                return response.data
            } catch (e) {
                return false
            }
        },

        async updateListColumns({commit, state}, params) {
            try {
                let response = await axios.put(`/api/columns/${params[0].id}`, params)
                return response.data
            } catch (e) {
                return false
            }

        },

        // /**
        //  *
        //  * @param commit
        //  * @param state
        //  * @param params
        //  * @returns {Promise<boolean|any>}
        //  */
        // async update({commit, state}, params) {
        //
        //     try {
        //         let response = await axios.put(`/api/items/${params.id}`, params)
        //         return response.data
        //     } catch (e) {
        //         return false
        //     }
        // }
    },

    mutations: {
        SET_ITEMS(state, data) {
            state.items = data
        }
    },

    getters: {
        getItems(state) {
            return state.items
        }
    }
}
