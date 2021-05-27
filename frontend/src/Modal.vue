<template>
  <transition name="fade">
    <div
        v-if="show"
        class="fixed p-4 inset-0 sm:flex sm:items-center sm:justify-center z-99999"
    >
      <div class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>

      <div
          class="relative bg-white rounded-lg px-4 pt-5 py-4 overflow-y-auto scrolling-touch max-h-full shadow-xl transform transition-all sm:w-full sm:p-6"
      >
        <div class="block absolute top-0 right-0 pt-4 pr-4">
          <button
              @click="close"
              type="button"
              class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150 bg-gray-200 rounded-full p-2 leading-none cursor-pointer flex justify-center items-center"
          >
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>

        <div class="pt-12 lg:pt-8"><slot></slot></div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {

  props: {
    show: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    close() {
      this.$emit("close");
    }
  },
  watch: {
    show(newVal) {
      window.document.body.classList.toggle("overflow-hidden", newVal === true);
    }
  }
};
</script>

<style lang="css">
.fade-enter-active,
.fade-leave-active {
  transition: opacity .28s ease-in-out;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
