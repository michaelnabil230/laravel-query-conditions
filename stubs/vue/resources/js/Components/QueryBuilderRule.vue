<template>
    <div class="md:grid flex overflow-x-auto md:grid-cols-4 gap-6 sm:px-6 p-3">
        <div>
            <label :for="'rules' + index" class="block text-sm font-medium text-gray-700">
                Rules
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <select :id="'rules' + index" v-model="query.rule"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 md:w-full">
                    <option selected>Choose a rules</option>
                    <option v-for="rule in rules" :key="rule.id" :value="rule.id">
                        {{ rule.label }}
                    </option>
                </select>
            </div>
        </div>
        <div>
            <label :for="'operators' + index" class="block text-sm font-medium text-gray-700">
                Operators
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <select :id="'operators' + index" v-model="query.operator"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 md:w-full">
                    <option selected>Choose a operators</option>
                    <option v-for="operator in rule.operators" :key="operator" :value="operator">
                        {{ operator }}
                    </option>
                </select>
            </div>
        </div>
        <div>
            <label :for="'value' + index" class="block text-sm font-medium text-gray-700">
                Value
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input type="text" :id="'value' + index" v-model="query.value"
                    class="focus:ring-indigo-500 focus:border-indigo-500 md:w-full rounded-md sm:text-sm border-gray-300">
            </div>
            <p class="mt-2 text-sm text-gray-500" v-if="rule.helpText" v-text="rule.helpText"></p>
        </div>
        <div class="flex items-end">
            <button v-on:click="remove"
                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span class="hidden md:block ml-1" v-text="labels.removeCondition"></span>
            </button>
        </div>
    </div>
</template>
<script>
export default {
    props: ['query', 'index', 'rule', 'rules', 'labels'],
    name: 'QueryBuilderRule',
    methods: {
        remove: function () {
            this.$emit('child-deletion-requested', this.index);
        },
    }
}
</script>