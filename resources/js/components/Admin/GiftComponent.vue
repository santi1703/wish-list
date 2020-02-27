<template>
    <div class="col-md-8 mt-2">
        <div class="card">
            <div class="card-header">Lista de regalos</div>

            <div class="card-body">

                <form @submit.prevent="editItem(gift)" v-if="editing">
                    <input type="text" class="form-control" placeholder="Nombre" v-model="gift.name">
                    <textarea rows="3" class="form-control" placeholder="Descripcion"
                              v-model="gift.description"></textarea>
                    <a class="btn btn-secondary" @click="cancelEditForm" :disabled="disableButtons" type="button">Cancelar</a>
                    <button class="btn btn-warning" type="submit" :disabled="disableButtons || invalidItem()">Guardar
                    </button>
                </form>

                <form @submit.prevent="addItem" v-else>
                    <input type="text" class="form-control" placeholder="Nombre" v-model="gift.name">
                    <textarea rows="3" class="form-control" placeholder="Descripcion"
                              v-model="gift.description"></textarea>
                    <button class="btn btn-primary" type="submit" :disabled="disableButtons || invalidItem()">Agregar
                    </button>
                </form>

                <ul class="list-group">
                    <li class="list-group-item"
                        v-for="(item, index) in gifts" :key="index">
                        <p data-toggle="tooltip" :title="item.description">{{ item.name }}</p>
                        <button class="btn btn-warning btn-sm float-right mr-1"
                                data-toggle="tooltip"
                                :title="getTooltip(item)"
                                :disabled="item.user_id || disableButtons"
                                @click="editForm(item)">Editar
                        </button>
                        <button class="btn btn-danger btn-sm float-right mr-1"
                                data-toggle="tooltip"
                                :title="getTooltip(item)"
                                :disabled="item.user_id || disableButtons"
                                @click="deleteItem(item, index)">Borrar
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "GiftComponent",
        data() {
            return {
                gifts: [],
                gift: {id: 0, name: '', description: ''},
                editing: false,
                disableButtons: false
            }
        },
        created() {
            axios.get('/wish-list/public/admin/gifts')
                .then(res => {
                    this.gifts = res.data;
                })
        },
        methods: {
            addItem() {
                this.disableButtons = true;
                const params = {
                    name: this.gift.name,
                    description: this.gift.description
                };
                axios.post('/wish-list/public/admin/gifts', params)
                    .then(res => {
                        this.disableButtons = false;
                        this.gifts.push(res.data);
                        this.gift.name = '';
                        this.gift.description = '';
                    });
            },
            editItem(item, index) {
                this.disableButtons = true;
                const params = {name: item.name, description: item.description};
                axios.put(`/wish-list/public/admin/gifts/${item.id}`, params)
                    .then(res => {
                        this.disableButtons = false;
                        const index = this.gifts.findIndex(item => item.id === res.data.id);
                        this.gifts[index] = res.data;
                        this.editing = false;
                        this.gift.id = 0;
                        this.gift.name = '';
                        this.gift.description = '';
                    });
            },
            editForm(item, index) {
                this.editing = true;
                this.gift.id = item.id;
                this.gift.name = item.name;
                this.gift.description = item.description;
            },
            cancelEditForm() {
                this.editing = false;
                this.gift.id = 0;
                this.gift.name = '';
                this.gift.description = '';
                this.disableButtons = false;
                console.log(this.disableButtons);
            },
            deleteItem(item, index) {
                if (confirm('Estas seguro de borrar el regalo ' + item.name + '?')) {
                    this.disableButtons = true;
                    axios.delete(`/wish-list/public/admin/gifts/${item.id}`)
                        .then(() => {
                            this.disableButtons = false;
                            this.gifts.splice(index, 1);
                        });
                }
            },
            getTooltip(item) {
                if (item.user) {
                    return "Asignado a " + item.user.fullName;
                } else {
                    return "";
                }
            },
            invalidItem() {
                return this.gift.name.length == 0 || this.gift.description.length == 0;
            }
        }
    }
</script>

<style scoped>

</style>
