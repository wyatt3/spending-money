<template>
  <transition name="fade">
    <div v-if="open">
      <div class="modal-background" @click="$emit('closed')"></div>
      <div class="modal-main bg-light text-dark">
        <h2>Create Transaction</h2>
        <button class="close" @click="$emit('closed')">&times;</button>
        <form @submit.prevent="submit()">
          <div class="form-group">
            <label for="amount">Amount</label>
            <input
              type="number"
              step="0.01"
              class="form-control bg-dark text-light"
              id="amount"
              v-model="amount"
            />
          </div>
          <div class="form-group mb-3">
            <label for="description">Description</label>
            <input
              type="text"
              class="form-control bg-dark text-light"
              id="description"
              v-model="description"
            />
          </div>
          <button type="submit" class="btn btn-dark w-100">Submit</button>
        </form>
      </div>
    </div>
  </transition>
</template>

<script>
import axios from "axios";
export default {
  props: ["user", "open"],
  data() {
    return {
      amount: null,
      description: "",
    };
  },
  methods: {
    submit() {
      axios
        .post("/api/transactions", {
          amount: -this.amount,
          description: this.description,
          user_id: this.user.id,
        })
        .then((response) => {
          this.$emit("created", response.data);
          this.$emit("closed");
        });
    },
  },
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter-to,
.fade-leave-from {
  opacity: 1;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.modal-background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0.5;
  background-color: black;
}

.modal-main {
  position: fixed;
  top: 50%;
  left: 50%;
  width: 80%;
  transform: translate(-50%, -50%);
  border-radius: 0.5rem;
  padding: 1rem;
}
.close {
  position: absolute;
  top: 0px;
  right: 10px;
  font-size: 2rem;
  background-color: transparent;
  border: none;
}
</style>
