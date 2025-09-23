<template>
  <div class="bg-white shadow-md rounded-lg overflow-hidden">
    <!-- Filtros -->
    <div class="p-4 border-b">
      <div class="flex flex-wrap gap-4 items-center">
        <div class="flex-1 min-w-[300px]">
          <input 
            v-model="search" 
            @input="debouncedSearch"
            type="text" 
            placeholder="Buscar por nombre, cédula, email, celular..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
        </div>
        <select 
          v-model="perPage" 
          @change="fetchUsers"
          class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          <option value="10">10 por página</option>
          <option value="25">25 por página</option>
          <option value="50">50 por página</option>
        </select>
      </div>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th 
              v-for="column in columns" 
              :key="column.key"
              @click="sortBy(column.key)"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
            >
              <div class="flex items-center">
                {{ column.label }}
                <span v-if="sortColumn === column.key" class="ml-1">
                  {{ sortDirection === 'asc' ? '↑' : '↓' }}
                </span>
              </div>
            </th>
            <th class="px-6 py-3 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ user.cedula }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ user.phone }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ user.age }} años</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ user.full_location }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right">
              <button @click="editUser(user.id)" class="text-blue-600 hover:text-blue-900 mr-3">Editar</button>
              <button @click="deleteUser(user.id)" class="text-red-600 hover:text-red-900">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <div class="px-6 py-4 border-t flex items-center justify-between">
      <div class="text-sm text-gray-700">
        Mostrando {{ pagination.from }} a {{ pagination.to }} de {{ pagination.total }} resultados
      </div>
      <div class="flex space-x-2">
        <button 
          @click="changePage(pagination.current_page - 1)"
          :disabled="pagination.current_page === 1"
          class="px-3 py-1 border rounded disabled:opacity-50"
        >
          Anterior
        </button>
        <span class="px-3 py-1">Página {{ pagination.current_page }} de {{ pagination.last_page }}</span>
        <button 
          @click="changePage(pagination.current_page + 1)"
          :disabled="pagination.current_page === pagination.last_page"
          class="px-3 py-1 border rounded disabled:opacity-50"
        >
          Siguiente
        </button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      users: [],
      search: '',
      perPage: 10,
      sortColumn: 'created_at',
      sortDirection: 'desc',
      pagination: {},
      columns: [
        { key: 'name', label: 'Nombre' },
        { key: 'email', label: 'Email' },
        { key: 'cedula', label: 'Cédula' },
        { key: 'phone', label: 'Teléfono' },
        { key: 'age', label: 'Edad' },
        { key: 'full_location', label: 'Ubicación' }
      ],
      debounceTimer: null
    }
  },
  mounted() {
    this.fetchUsers()
  },
  methods: {
    async fetchUsers(page = 1) {
      const params = new URLSearchParams({
        page,
        search: this.search,
        per_page: this.perPage,
        sort: this.sortColumn,
        direction: this.sortDirection
      })

      try {
        const response = await fetch(`/admin/users?${params}`)
        const data = await response.json()
        
        this.users = data.users
        this.pagination = data.pagination
      } catch (error) {
        console.error('Error fetching users:', error)
      }
    },
    debouncedSearch() {
      clearTimeout(this.debounceTimer)
      this.debounceTimer = setTimeout(() => {
        this.fetchUsers(1)
      }, 500)
    },
    sortBy(column) {
      if (this.sortColumn === column) {
        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc'
      } else {
        this.sortColumn = column
        this.sortDirection = 'asc'
      }
      this.fetchUsers(1)
    },
    changePage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.fetchUsers(page)
      }
    },
    editUser(userId) {
      window.location.href = `/admin/users/${userId}/edit`
    },
    async deleteUser(userId) {
      if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
        try {
          await fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          })
          this.fetchUsers() // Aquí faltaba cerrar la llamada y el método
        } catch (error) {
          console.error('Error deleting user:', error)
        }
      }
    } // Faltaba cerrar el método deleteUser
  } // Faltaba cerrar el objeto methods
} // Faltaba cerrar el objeto del componente
</script>