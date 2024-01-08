import {instance} from "./httpClient";

export const query = {
    on: function (table) {
        console.log('lookup query', table)
        return typeof this[table] === 'undefined' ? this.index(table) : this[table]
    },
    index: (table) => {
        return (q, f = 'meaning') => instance.get(`/api/pd/lookup/${table}`, {params: {q, f}})
    },
    ptinvItemcatMatgroupV: (q, f = 'meaning') => instance.get('/api/pd/lookup/PtinvItemcatMatgroupV', {params: {q, f}}),
}
