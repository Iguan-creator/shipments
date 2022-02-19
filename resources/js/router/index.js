import VueRouter from 'vue-router'
import MainPage from "../components/pages/MainPage";
import CreatePage from "../components/pages/CreatePage";
import EditPage from "../components/pages/EditPage"
import CreatePageCompact from "../components/pages/CreatePageCompact"
import EditPageClassic from "../components/pages/EditPageClassic"
import ShipmentsAllPage from "../components/pages/ShipmentsAllPage";
import ShipmentsMyPage from "../components/pages/ShipmentsMyPage";
import ShipmentPage from "../components/pages/ShipmentPage";
import ReportsSelectorPage from "../components/pages/ReportsSelectorPage";
import ReportPage from "../components/pages/ReportPage";
import CustomReportPage from "../components/pages/CustomReportPage";
import SettingsPage from "../components/pages/SettingsPage";
import EditShipmentPage from "../components/pages/EditShipmentPage";

const routes = [
    {
        path: '/EditShipmentPage',
        name: 'EditShipmentPage',
        component: EditShipmentPage
    },
    {
        path: '/settings',
        name: 'Settings',
        component: SettingsPage
    },
    {
        path: '/',
        name: 'Main',
        component: MainPage
    },
    {
        path: '/create',
        name: 'Create',
        component: CreatePage
    },
    {
        path: '/create/copy',
        name: 'CreateCopy',
        component: CreatePage
    },
    {
        path: '/create/copy/compact',
        name: 'CreateCopyCompact',
        component: CreatePageCompact
    },
    {
        path: '/:id/edit',
        name: 'Edit',
        component: EditPage,
        props: true
    },
    {
        path: '/:id/editclassic',
        name: 'EditPageClassic',
        component: EditPageClassic,
        props: true
    },
    {
        path: '/reports/:listName',
        name: 'ReportsSelector',
        component: ReportsSelectorPage,
        props: true
    },
    {
        path: '/report/:listName/:id',
        name: 'Report',
        component: ReportPage,
        props: true
    },
    {
        path: '/report/:listName',
        name: 'ReportOverall',
        component: ReportPage,
        props: true
    },
    {
        path: '/custom_report',
        name: 'CustomReport',
        component: CustomReportPage,
    },
    {
        path: '/shipment/:id',
        name: 'Shipment',
        component: ShipmentPage,
        props: true
    },
    {
        path: '/shipments/my',
        name: 'ShipmentsMy',
        component: ShipmentsMyPage
    },
    {
        path: '/shipments',
        name: 'ShipmentsAll',
        component: ShipmentsAllPage
    },
    {
        path: '/lists',
        name: 'Lists',
        component: function () {
            return import(/* webpackChunkName: "js/pages/lists" */ '../components/pages/ListsPage')
        }
    },
    {
        path: '/types',
        name: 'Types',
        component: function () {
            return import(/* webpackChunkName: "js/pages/types" */ '../components/pages/TypesPage')
        }
    },
    {
      path: '/users',
      name: 'Users',
      component: function () {
        return import(/* webpackChunkName: "js/pages/users" */ '../components/pages/UsersEditPage')
      }
    },
    {
        path: '/shipments_user',
        name: 'ShipmentsUser',
        component: function () {
            return import(/* webpackChunkName: "js/pages/shipments_user" */ '../components/pages/ShipmentsUserPage')
        }
    },
    {
        path: '/dependencies/:dependency/:source/:id',
        name: 'Dependencies',
        props: true,
        component: function () {
            return import(/* webpackChunkName: "js/pages/dependencies" */ '../components/pages/DependencyPage')
        }
    },
    {
        path: '/lists/:list',
        name: 'List',
        props: true,
        component: function () {
            return import(/* webpackChunkName: "js/pages/lists" */ '../components/pages/ListPage')
        }
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router
