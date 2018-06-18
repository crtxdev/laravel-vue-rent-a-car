import Vue from 'vue'
import fontawesome from '@fortawesome/fontawesome'
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'

// import { } from '@fortawesome/fontawesome-free-regular/shakable.es'

import {
  faUser, faLock, faSignOutAlt, faCog, faTachometerAlt, faCalendarAlt, faLocationArrow, faCar, faUsers, faSortAmountUp, faSortAmountDown, faCaretDown, faEye, faPencilAlt, faTrashAlt, faSave, faArrowAltCircleLeft, faArrowAltCircleRight, faEllipsisH, faBars, faPlus, faTimes, faListAlt, faPrint
} from '@fortawesome/fontawesome-free-solid/shakable.es'

fontawesome.library.add(
  faUser, faLock, faSignOutAlt, faCog, faTachometerAlt, faCalendarAlt, faLocationArrow, faCar, faUsers, faSortAmountUp, faSortAmountDown, faCaretDown, faEye, faPencilAlt, faTrashAlt, faSave, faArrowAltCircleLeft, faArrowAltCircleRight, faEllipsisH, faBars, faPlus, faTimes, faListAlt, faPrint
)

Vue.component('fa', FontAwesomeIcon)
