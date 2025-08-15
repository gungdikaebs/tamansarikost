import { ref, watch } from "vue";

export function useSearch(router, routePath) {
    const search = ref("");

    watch(search, (newSearch) => {
        router.get(
            routePath,
            { search: newSearch },
            { preserveState: true, replace: true }
        );
    });

    function setSearch(value) {
        search.value = value;
    }

    return {
        search,
        setSearch,
    };
}
