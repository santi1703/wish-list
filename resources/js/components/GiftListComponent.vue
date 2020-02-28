<template>
    <div class="col-md-8 mt-2">
        <div class="card">
            <div class="card-header"><h1>Lista de regalos</h1></div>

            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item"
                        v-for="(item, index) in gifts" :key="index">
                        <h3>{{ item.name }}</h3>
                        <p>{{ item.description }}</p>
                        <button class="btn btn-success btn-sm float-right mr-1"
                                :disabled="unselectable(item) || disableButtons"
                                v-if="checkOwner(item) == 'none'"
                                @click="assignItem(item, index)">Elegir
                        </button>
                        <button class="btn btn-danger btn-sm float-right mr-1"
                                :disabled="unselectable(item) || disableButtons"
                                v-if="checkOwner(item) == 'other'"
                                @click="assignItem(item, index)">Ya elegido
                        </button>
                        <button class="btn btn-warning btn-sm float-right mr-1"
                                :disabled="unselectable(item) || disableButtons"
                                v-if="checkOwner(item) == 'self'"
                                @click="unassignItem(item, index)">Dejar de elegir
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "GiftListComponent",
        props: ['baseurl', 'userid'],
        data() {
            return {
                gifts: [],
                gift: {id: 0, name: '', description: ''},
                editing: false,
                disableButtons: false
            }
        },
        created() {
            axios.get(this.baseurl + '/gifts')
                .then(res => {
                    this.gifts = res.data;
                })
        },
        methods: {
            assignItem(item, index) {
                if (confirm('Estas seguro de elegir el regalo ' + item.name + '?')) {
                    this.disableButtons = true;
                    axios.post(this.baseurl + `/gifts/assign/${item.id}`)
                        .then(res => {
                            this.disableButtons = false;
                            this.gifts[index] = res.data;
                        });
                }
            },
            unassignItem(item, index) {
                if (confirm('Estas seguro de dejar de elegir el regalo ' + item.name + '?')) {
                    this.disableButtons = true;
                    axios.post(this.baseurl + `/gifts/unassign/${item.id}`)
                        .then(res => {
                            this.disableButtons = false;
                            this.gifts[index] = res.data;
                        });
                }
            },
            checkOwner(item) {
                switch (item.user_id) {
                    case null:
                        return 'none';
                    case parseInt(this.userid):
                        return 'self';
                    default:
                        return 'other';
                }
            },
            unselectable(item) {
                return item.user_id != null && item.user_id != parseInt(this.userid);
            }
        }
    }
</script>

<style scoped>

</style>
