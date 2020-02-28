<template>
    <div class="col-md-8 mt-2">
        <div class="card">
            <div class="card-header"><h1>Lista de regalos</h1></div>

            <div class="card-body">

                <form @submit.prevent="editItem(gift)" v-if="editing">
                    <input type="text" class="form-control mt-1" placeholder="Nombre" v-model="gift.name" maxlength="200">
                    <textarea rows="3" class="form-control mt-1" placeholder="Descripcion"
                              v-model="gift.description" style="resize: none;" maxlength="500"></textarea>
                    <a class="btn btn-secondary mt-1" @click="cancelEditForm" :disabled="disableButtons" type="button">Cancelar</a>
                    <button class="btn btn-warning mt-1" type="submit" :disabled="disableButtons || invalidItem()">Guardar
                    </button>
                </form>

                <form @submit.prevent="addItem" v-else>
                    <input type="text" class="form-control mt-1" placeholder="Nombre" v-model="gift.name"  maxlength="200">
                    <textarea rows="3" class="form-control mt-1" placeholder="Descripcion"
                              v-model="gift.description" style="resize: none;"  maxlength="500"></textarea>
                    <button class="btn btn-primary mt-1" type="submit" :disabled="disableButtons || invalidItem()">Agregar
                    </button>
                </form>

                <ul class="list-group">
                    <li class="list-group-item"
                        v-for="(item, index) in gifts" :key="index">
                        <h3>{{ item.name }}</h3>
                        <p>{{ item.description }}</p>
                        <span class="badge badge-secondary" v-bind="getTooltip(item)"></span>
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
                        <button class="btn btn-primary btn-sm float-right mr-1"
                                data-toggle="tooltip"
                                :title="getTooltip(item)"
                                :disabled="!item.user_id || disableButtons"
                                @click="unassignItem(item, index)">Desasignar
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
        props: ['baseurl'],
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
            addItem() {
                this.disableButtons = true;
                const params = {
                    name: this.gift.name,
                    description: this.gift.description
                };
                axios.post(this.baseurl + '/gifts', params)
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
                axios.put(this.baseurl + `/gifts/${item.id}`, params)
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
                    axios.delete(this.baseurl + `/gifts/${item.id}`)
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
            },
            unassignItem(item, index) {
                if (confirm('Estas seguro de desasignar el regalo ' + item.name + '?')) {
                    this.disableButtons = true;
                    axios.post(this.baseurl + `/gifts/unassign/${item.id}`)
                        .then(res => {
                            this.disableButtons = false;
                            this.gifts[index] = res.data;
                        });
                }
            },
        }
    }
</script>

<style scoped>

</style>
