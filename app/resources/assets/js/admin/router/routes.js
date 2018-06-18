const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

const Home = () => import('~/admin/pages/home').then(m => m.default || m)
const Appointments = () => import('~/admin/pages/appointments/index').then(m => m.default || m)
const AppointmentsView = () => import('~/admin/pages/appointments/view').then(m => m.default || m)
const AppointmentsEdit = () => import('~/admin/pages/appointments/edit').then(m => m.default || m)
const Locations = () => import('~/admin/pages/locations/index').then(m => m.default || m)
const LocationsCreate = () => import('~/admin/pages/locations/create').then(m => m.default || m)
const LocationsView = () => import('~/admin/pages/locations/view').then(m => m.default || m)
const LocationsEdit = () => import('~/admin/pages/locations/edit').then(m => m.default || m)
const Cars = () => import('~/admin/pages/cars/index').then(m => m.default || m)
const CarsCreate = () => import('~/admin/pages/cars/create').then(m => m.default || m)
const CarsView = () => import('~/admin/pages/cars/view').then(m => m.default || m)
const CarsEdit = () => import('~/admin/pages/cars/edit').then(m => m.default || m)
const Users = () => import('~/admin/pages/users/index').then(m => m.default || m)
const UsersCreate = () => import('~/admin/pages/users/create').then(m => m.default || m)
const UsersView = () => import('~/admin/pages/users/view').then(m => m.default || m)
const UsersEdit = () => import('~/admin/pages/users/edit').then(m => m.default || m)

export default [

  { path: '/', name: 'home', component: Home },

  { path: '/appointments', name: 'appointments', component: Appointments, meta: { permissions: ['view appointments'] } },
  { path: '/appointments/:id/edit', name: 'appointments.edit', component: AppointmentsEdit, meta: { permissions: ['edit appointments'] } },
  { path: '/appointments/:id', name: 'appointments.view', component: AppointmentsView, meta: { permissions: ['view appointments'] } },

  { path: '/locations', name: 'locations', component: Locations, meta: { permissions: ['view locations'] } },
  { path: '/locations/create', name: 'locations.create', component: LocationsCreate, meta: { permissions: ['create locations'] } },
  { path: '/locations/:id/edit', name: 'locations.edit', component: LocationsEdit, meta: { permissions: ['edit locations'] } },
  { path: '/locations/:id', name: 'locations.view', component: LocationsView, meta: { permissions: ['view locations'] } },

  { path: '/cars', name: 'cars', component: Cars, meta: { permissions: ['view cars'] } },
  { path: '/cars/create', name: 'cars.create', component: CarsCreate, meta: { permissions: ['create cars'] } },
  { path: '/cars/:id/edit', name: 'cars.edit', component: CarsEdit, meta: { permissions: ['edit cars'] } },
  { path: '/cars/:id', name: 'cars.view', component: CarsView, meta: { permissions: ['view cars'] } },

  { path: '/users', name: 'users', component: Users, meta: { permissions: ['view users'] } },
  { path: '/users/create', name: 'users.create', component: UsersCreate, meta: { permissions: ['create users'] } },
  { path: '/users/:id/edit', name: 'users.edit', component: UsersEdit, meta: { permissions: ['edit users'] } },
  { path: '/users/:id', name: 'users.view', component: UsersView, meta: { permissions: ['view users'] } },

  { path: '*', component: NotFound }

]
