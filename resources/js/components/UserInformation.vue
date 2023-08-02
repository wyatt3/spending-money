<template>
  <div>
    <!-- User names -->
    <div class="d-flex justify-content-evenly">
      <div v-for="user in users" :key="user.id">
        <button @click="setActiveUser(user.id)">
          {{ user.name }}
        </button>
      </div>
    </div>
    <!-- User balances and transactions -->
    <div class="anchor">
      <div v-for="user in users" :key="user.id" class="user-info">
        <transition name="fade">
          <div v-if="user.id == activeUser" class="container">
            <p class="m-auto text-center mt-3">Current Balance:</p>
            <h2
              class="m-auto text-center mb-3"
              v-text="format(user.balance)"
            ></h2>
            <button
              class="w-100 btn btn-dark mb-2"
              v-if="user.id == logged_in_user.id"
              @click="open = true"
            >
              Add transaction
            </button>
            <add-transaction
              :open="open"
              @closed="closeModal"
              @created="handleCreatedTransaction"
              :user="user"
            ></add-transaction>
            <user-transactions
              @deleted="handleDeletedTransaction"
              :transactions="transactions[user.id]"
            ></user-transactions>
          </div>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import UserTransactions from "./UserTransactions.vue";
import AddTransaction from "./AddTransaction.vue";
export default {
  props: ["users", "logged_in_user"],
  components: {
    UserTransactions,
    AddTransaction,
  },
  data() {
    return {
      activeUser: null,
      open: false,
      transactions: [],
    };
  },
  methods: {
    setActiveUser(userId) {
      this.activeUser = userId;
    },
    format(number) {
      return number.toLocaleString("en-US", {
        style: "currency",
        currency: "USD",
      });
    },
    handleCreatedTransaction(e) {
      this.transactions[e.user_id].unshift(e);
      this.users.find((u) => u.id === e.user_id).balance += e.amount;
    },
    handleDeletedTransaction(e) {
      this.transactions[e.user_id] = this.transactions[e.user_id].filter(
        (t) => t.id !== e.id
      );
      this.users.find((u) => u.id === e.user_id).balance -= e.amount;
    },
    closeModal() {
      this.open = false;
    },
  },
  created() {
    axios.get("/api/transactions").then((response) => {
      this.transactions = response.data;
    });
    this.setActiveUser(this.logged_in_user.id);
  },
};
</script>

<style scoped>
.anchor {
  position: relative;
}

.user-info {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
}

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
</style>
