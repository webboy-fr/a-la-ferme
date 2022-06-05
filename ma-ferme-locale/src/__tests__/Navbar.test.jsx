import { cleanup, screen, render } from '@testing-library/react';
import Navbar from '../components/Navbar';

afterEach(cleanup);

it('Navbar component render correctly', () => {
    render(<Navbar />);
    const linkElement = screen.getByText(/Ma Ferme Locale/i);
    expect(linkElement).toBeInTheDocument();
});


