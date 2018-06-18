<template>
  <tbody>
    <template v-if="data.length">
      <template v-for="item in data">
        <tr>
          <td v-if="shouldRenderSelection">
            <multi-select :selection="selection" :row="item" />
          </td>
          <td v-for="col in columns" :style="col.tdStyle" :class="{ 'datatable-action-cell': col.field == 'actions'  }">
            <!-- <td> component (tdComp) -->
            <component
              v-if="col.tdComp"
              :is="forDynCompIs(col.tdComp)"
              :row="item"
              :field="col.field"
              :value="item[col.field]"
              :nested="item.__nested__"
              v-bind="$props">
            </component>
            <template v-else>
              <template v-if="col.field == 'actions'">
                <template v-if="item[col.field].view">
                  <router-link :to="item[col.field].view.route" class="datatable-action">
                    <fa :icon="item[col.field].view.icon" />
                  </router-link>
                </template>
                <template v-if="item[col.field].edit">
                  <router-link :to="item[col.field].edit.route" class="datatable-action">
                    <fa :icon="item[col.field].edit.icon" />
                  </router-link>
                </template>
              </template>
              <template v-else>
                <div v-html="item[col.field]"></div>
              </template>
            </template>
          </td>
        </tr>
        <transition name="fade">
          <tr v-if="item.__nested__ && item.__nested__.visible">
            <td :colspan="colLen">
              <!-- nested component -->
              <component
                :is="forDynCompIs(item.__nested__.comp)"
                :row="item"
                :nested="item.__nested__"
                v-bind="$props">
              </component>
            </td>
          </tr>
        </transition>
      </template>
    </template>
    <tr v-else-if="!leftFixed && !rightFixed">
      <td :colspan="colLen" class="text-center text-muted">
        ( {{ $i18nForDatatable('No Data') }} )
      </td>
    </tr>
  </tbody>
</template>
<script>
import MultiSelect from './MultiSelect.vue'
import props from '../_mixins/props'
import shouldRenderSelection from '../_mixins/shouldRenderSelection'

export default {
  name: 'TableBody',
  components: { MultiSelect },
  mixins: [props, shouldRenderSelection],
  computed: {
    colLen () {
      return this.columns.length + !!this.selection
    }
  }
}
</script>
