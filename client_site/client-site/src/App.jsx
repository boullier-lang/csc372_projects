import { Routes, Route } from 'react-router-dom'
import Navbar from './components/navBar'
import Home from './pages/Home'
import About from './pages/About'
import GCards from './pages/Gift_Cards'
import Reviews from './pages/Reviews'
import Staff from './pages/Staff'
import Services from './pages/Services.jsx'
import Order from './pages/Order'



export default function App() {
  return (
    <>
      <Navbar />
      <Routes>
        <Route path="/" element={<Home />} />
		<Route path="/about" element={<About />} />
		<Route path="/staff" element={<Staff />} />
		<Route path="/reviews" element={<Reviews />} />
		<Route path="/gift-cards" element={<GCards />} />
		<Route path="/services" element={<Services />} />
		<Route path="/order" element={<Order />} />
      </Routes>
    </>
  )
}