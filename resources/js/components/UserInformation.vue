<template>
  <div>
    <!-- User names -->
    <div class="d-flex justify-content-evenly">
      <div v-for="user in users" :key="user.id">
        <button @click="setActiveUser(user.id)">{{ user.name }}</button>
      </div>
    </div>
    <!-- User balances and transactions -->
    <div class="anchor">
      <div v-for="user in users" :key="user.id" class="user-info">
        <transition name="fade">
          <div v-if="user.id == activeUser" class="container">
            <h2 v-text="format(user.balance)"></h2>
            <div v-if="user.id == logged_in_user.id">Add transaction</div>
            <user-transactions
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
export default {
  props: ["users", "logged_in_user"],
  components: {
    UserTransactions,
  },
  data() {
    return {
      activeUser: null,
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
  },
  created() {
    axios.get("/api/transactions").then((response) => {
      this.transactions = response.data;
      console.log(response.data);
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
