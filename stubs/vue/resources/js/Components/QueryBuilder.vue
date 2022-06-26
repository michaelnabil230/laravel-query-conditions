<template>
    <div class="container p-3 m-auto">
        <div class="m-2">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white space-y-6">
                    <div class="flex justify-between items-center border-b-2 py-4 sm:p-6">
                        <div>
                            <h1 class="md:px-0 px-2 text-lg leading-6 font-medium text-gray-900">
                                Conditions
                            </h1>
                            <p class="md:px-0 px-2 mt-2 text-base leading-6 text-gray-500">
                                Narrow down when this rule should apply by adding conditions. Currently, only simple
                                operators are supported.
                            </p>
                        </div>
                        <button @click="addCondition" type="button"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ labels.addCondition }}
                        </button>
                    </div>
                    <QueryBuilderRule v-for="(child, index) in query.children" :key="index" :query.sync="child.query"
                        :rule-types="ruleTypes" :rules="vqbProps.rules" :rule="ruleById(child.query.rule)" :labels="labels"
                        :index="index" @child-deletion-requested="removeChild">
                    </QueryBuilderRule>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button v-on:click="clickable"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ labels.getResults }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import QueryBuilderRule from './QueryBuilderRule.vue';
var defaultLabels = {
    matchType: "Match Type",
    matchTypes: [
        { "id": "all", "label": "All" },
        { "id": "any", "label": "Any" },
    ],
    addCondition: "Add Condition",
    removeCondition: "Remove",
    addGroup: "Add Group",
    getResults:"Get Results"
};
export default {
    name: 'QueryBuilder',
    components: {
        QueryBuilderRule
    },
    props: {
        rules: Array,
        labels: {
            type: Object,
            default() {
                return defaultLabels;
            }
        },
        value: Object,
        clickable: Function,
    },
    data() {
        return {
            query: {
                logicalOperator: this.labels.matchTypes[0].id,
                children: []
            },
            ruleTypes: {
                "text": {
                    operators: ['equals', 'does not equal', 'contains', 'does not contain', 'is empty', 'is not empty', 'begins with', 'ends with'],
                    inputType: "text",
                    id: "text-field"
                },
                "numeric": {
                    operators: ['=', '<>', '<', '<=', '>', '>='],
                    inputType: "number",
                    id: "number-field"
                },
                "custom": {
                    operators: [],
                    inputType: "text",
                    id: "custom-field"
                },
                "radio": {
                    operators: [],
                    choices: [],
                    inputType: "radio",
                    id: "radio-field"
                },
                "checkbox": {
                    operators: [],
                    choices: [],
                    inputType: "checkbox",
                    id: "checkbox-field"
                },
                "select": {
                    operators: ['=', '!='],
                    choices: [],
                    inputType: "select",
                    id: "select-field"
                },
                "multi-select": {
                    operators: ['='],
                    choices: [],
                    inputType: "select",
                    id: "multi-select-field"
                },
            }
        }
    },
    computed: {
        mergedLabels() {
            return Object.assign({}, defaultLabels, this.labels);
        },
        mergedRules() {
            var mergedRules = [];
            var vm = this;
            vm.rules.forEach(function (rule) {
                if (typeof vm.ruleTypes[rule.type] !== "undefined") {
                    mergedRules.push(Object.assign({}, vm.ruleTypes[rule.type], rule));
                } else {
                    mergedRules.push(rule);
                }
            });
            return mergedRules;
        },
        vqbProps() {
            return {
                index: 0,
                ruleTypes: this.ruleTypes,
                rules: this.mergedRules,
                labels: this.mergedLabels
            }
        }
    },
    mounted() {
        this.$watch(
            'query',
            newQuery => {
                if (JSON.stringify(newQuery) !== JSON.stringify(this.value)) {
                    this.$emit('input', newQuery);
                }
            }, {
            deep: true
        });
        this.$watch(
            'value',
            newValue => {
                if (JSON.stringify(newValue) !== JSON.stringify(this.query)) {
                    this.query = newValue;
                }
            }, {
            deep: true
        });
        if (typeof this.$options.propsData.value !== "undefined") {
            this.query = Object.assign(this.query, this.$options.propsData.value);
        }
    },
    methods: {
        ruleById(ruleId) {
            return this.vqbProps.rules.find(value => value.id === ruleId);
        },
        removeChild(index) {
            this.query.children.splice(index, 1);
        },
        addCondition() {
            var selectedRule = this.vqbProps.rules[0];
            let child = {
                type: 'query-builder-rule',
                query: {
                    rule: selectedRule.id,
                    operator: selectedRule.operators[0],
                    value: ""
                }
            };

            // A bit hacky, but `v-model` on `select` requires an array.
            if (this.ruleById(child.query.rule).type === 'multi-select') {
                child.query.value = [];
            }

            this.query.children.push(child);
            this.$emit('update:query', this.query);
        },
    }
}
</script>