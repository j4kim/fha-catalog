<script setup>
import { reactive } from "vue";
import { useRoute } from "vue-router";
import Attr from "../../components/Attr.vue";
import store from "../../store";
import router from "../../router";
import { get } from "../../api";

const route = useRoute();

const state = reactive({
    fund: {},
});

state.fund = await get(`/api/funds/${route.params.fundId}?with=lots`);

store.breadcrumbs = [
    { text: "Funds", route: "/funds/" },
    { text: state.fund.ref },
];
store.menu = [
    { text: "Update fund", route: `/funds/${state.fund.id}/update`, if: window.user },
    { text: "Delete fund", route: `/funds/${state.fund.id}/delete`, if: window.user },
];
</script>

<template>
    <div class="flex flex-col gap-6" v-if="state.fund">
        <div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
            <Attr label="Ref" :value="state.fund.ref" />
            <Attr label="Name" :value="state.fund.name" />
            <Attr
                label="Description"
                :value="state.fund.description"
                class="sm:col-span-4"
                value-class="whitespace-pre-line"
            />
        </div>

        <div class="flex flex-col gap-4">
            <h3 class="font-semibold text-xl text-gray-800">
                Lots dans ce fond
            </h3>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ref</th>
                        <th>Name</th>
                        <th class="hidden sm:table-cell">Description</th>
                        <th>Status</th>
                        <th class="hidden md:table-cell">Update</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="cursor-pointer"
                        v-for="lot in state.fund.lots"
                        @click="
                            router.push(`/funds/${lot.fund_id}/lots/${lot.id}`)
                        "
                    >
                        <td>{{ lot.id }}</td>
                        <td>{{ lot.ref }}</td>
                        <td>{{ lot.name }}</td>
                        <td class="hidden sm:table-cell text-sm lg:text-base">
                            {{ lot.description }}
                        </td>
                        <td>{{ lot.status }}</td>
                        <td class="hidden md:table-cell">
                            {{ lot.updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
