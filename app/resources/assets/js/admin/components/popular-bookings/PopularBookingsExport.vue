<template>
<div class="ref">
  <button type="button" class="btn btn-primary" @click="toggleModal()">
    <fa icon="clipboard-list" fixed-width />
    {{ $t('generate_report') }}
  </button>
  <div class="modal" tabindex="-1" role="dialog" ref="modal">
    <div class="modal-dialog" role="document" data-backdrop="static">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $t('generate_report') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <template v-if="generating">
            <div class="generating">
              {{ $t('generating_in_progress') }}...
            </div>
          </template>
          <template v-else>
            <template v-if="this.url">
              <div class="text-center">
                <a :href="this.url" download class="btn btn-primary btn-lg">
                  <fa icon="download" fixed-width></fa>
                  {{ $t('download_file') }}
                </a>
              </div>
            </template>
            <template v-else>
              <p>{{ $t('period') }} ({{ $t('in_days') }})</p>
              <div class="form-group">
                <input type="number" v-model="period" class="form-control" />
              </div>
              <p>{{ $t('number_of_appointments') }}</p>
              <div class="form-group">
                <input type="number" v-model="count" class="form-control" />
              </div>
            </template>
          </template>
        </div>
        <div class="modal-footer" v-if="!this.url">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" :disabled="generating">{{ $t('close') }}</button>
          <button type="button" class="btn btn-primary" @click="generate" :disabled="generating">{{ $t('generate_report') }}</button>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>

  import $ from 'jquery';
  import axios from 'axios';
  
  export default {

    data: () => ({
      generating: false,
      period: 30,
      count: 122,
      url: null
    }),

    mounted() {
      $(this.$refs.modal).on('hidden.bs.modal', () => {
        this.url = null
      })
    },

    methods: {
      toggleModal(){
        $(this.$refs.modal).modal('toggle')
      },
      async generate(){
        this.generating = true
        const { data } = await axios.get('/api/admin/popular-bookings/report', {
          params: {
            period: this.period,
            count: this.count
          }
        })
        this.url = data.url
        this.generating = false

      }
    }

  }

</script>

<style scoped>
  .ref {
    position: absolute;
    top: 0;
  }
  .generating {
    font-size: 18px;
    text-align: center;
  }
</style>