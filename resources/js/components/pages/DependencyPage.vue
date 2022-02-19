<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <nav class="float-right mt-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link :to="'/' + source + 's'">{{ sourceName }}</router-link>
                        </li>
                        <li class="breadcrumb-item">{{ sourceValue }}</li>
                        <li class="breadcrumb-item">{{ dependencyName }}</li>
                    </ol>
                </nav>
                <h3 class="mb-1 mt-0">Зависимости "{{ dependencyName }}" от "{{ sourceName }}: <span
                    class="text-primary">{{ sourceValue }}</span>"</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div v-if="asyncDataStatus_ready">
                            <div>
                                <div v-for="element in dependencies" :id="dependency.id" :key="dependency.id"
                                     class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input"
                                           :id="`${dependency}_${element.id}`"
                                           v-model="element.checked"
                                    >
                                    <label class="custom-control-label" :for="`${dependency}_${element.id}`">
                                        {{ element.name }}
                                    </label>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button @click="save" :class="saved ? 'btn-soft-primary' : 'btn-primary'"
                                        class="btn btn-primary">
                                    {{ saved ? 'Сохранено' : 'Изменить' }}
                                </button>
                            </div>
                        </div>
                        <app-data-loader v-else></app-data-loader>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->

    </div>
</template>

<script>
import AppDataLoader from "../AppDataLoader";
import asyncDataStatus from "../../mixins/asyncDataStatus";

export default {
    name: "DependencyPage",
    components: {AppDataLoader},
    mixins: [asyncDataStatus],
    data() {
        return {
            sourceName: '',
            sourceValue: '',
            dependencyName: '',
            dependencies: [],
            saved: false
        }
    },
    computed: {
        dependency: function () {
            return this.$route.params.dependency
        },
        source: function () {
            return this.$route.params.source
        },
        id: function () {
            return this.$route.params.id
        },
        request: function () {
            let words = [this.dependency, this.source];
            words.sort();
            return words[0] + '_' + words[1];
        }
    },
    created() {
        this.initialize();
    },
    beforeRouteUpdate(to, from, next) {
        this.initialize();
        next();
    },
    methods: {
        initialize() {
            // Set initial data
            if (this.source === 'type') {
                this.sourceName = 'Тип перевозки';
            } else {
                axios.get('/app/parameters/' + this.source)
                    .then(response => this.sourceName = response.data.singular_name);
            }

            axios.get(`/app/${this.source}s/${this.id}`)
                .then(response => this.sourceValue = response.data.name);

            axios.get('/app/parameters/' + this.dependency)
                .then(response => this.dependencyName = response.data.singular_name);

            axios.get(`/app/${this.request}/${this.id}`)
                .then(response => {
                    this.dependencies = response.data;
                    this.asyncDataStatus_fetched();
                });
        },
        save() {
            let data = this.dependencies
                .filter(value => value.checked)
                .map(value => value.id);

            axios.patch(`/app/${this.request}/${this.id}`, {data: data})
                .then(response => {
                    if (response.data === 'Success') {
                        this.saved = true;
                        setTimeout(() => this.saved = false, 3000);
                    }
                });
        }
    }
}
</script>

<style scoped>

</style>
