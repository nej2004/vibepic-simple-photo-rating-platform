# VibePic - Professional Photo Rating Platform

A modern, professional photo rating platform built with React, TypeScript, and Tailwind CSS. VibePic allows users to upload photos and receive detailed ratings from the community on posing, style, and creativity.

## ✨ Features

### 🎯 Core Functionality
- **Professional Rating System**: Rate photos on posing, style, and creativity with intuitive sliders
- **Social Scoring**: Advanced algorithm to calculate social scores based on community ratings
- **Photo Upload**: Drag-and-drop photo upload with preview and validation
- **User Profiles**: Comprehensive user profiles with statistics and photo galleries
- **Leaderboard**: Community rankings with podium display for top performers
- **Real-time Feedback**: Instant visual feedback and smooth animations

### 🎨 Design & UX
- **Modern UI**: Clean, professional design with Apple-level aesthetics
- **Responsive Design**: Optimized for all devices from mobile to desktop
- **Smooth Animations**: Framer Motion animations for enhanced user experience
- **Intuitive Navigation**: Easy-to-use navigation with clear visual hierarchy
- **Accessibility**: Built with accessibility best practices

### 🔧 Technical Features
- **TypeScript**: Full type safety throughout the application
- **State Management**: Zustand for efficient state management
- **Form Handling**: React Hook Form for robust form validation
- **API Integration**: React Query for efficient data fetching
- **Toast Notifications**: User-friendly feedback system
- **File Upload**: Advanced file handling with validation

## 🚀 Getting Started

### Prerequisites
- Node.js 18+ 
- npm or yarn

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd vibepic-professional
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Start the development server**
   ```bash
   npm run dev
   ```

4. **Open your browser**
   Navigate to `http://localhost:3000`

## 🏗️ Project Structure

```
src/
├── components/          # Reusable UI components
│   ├── auth/           # Authentication components
│   └── layout/         # Layout components (Navbar, etc.)
├── pages/              # Page components
│   ├── Home.tsx        # Landing page
│   ├── Login.tsx       # Login page
│   ├── Register.tsx    # Registration page
│   ├── Dashboard.tsx   # Photo rating interface
│   ├── Upload.tsx      # Photo upload page
│   ├── Profile.tsx     # User profile page
│   ├── Leaderboard.tsx # Community rankings
│   └── PhotoDetail.tsx # Individual photo view
├── stores/             # State management
│   └── authStore.ts    # Authentication state
├── utils/              # Utility functions
└── App.tsx            # Main application component
```

## 🎨 Design System

### Color Palette
- **Primary**: Red-based palette for main actions and branding
- **Secondary**: Gray-based palette for text and backgrounds
- **Semantic**: Success, warning, and error colors for feedback

### Typography
- **Font**: Inter for clean, modern readability
- **Weights**: 300, 400, 500, 600, 700
- **Scale**: Consistent typography scale for hierarchy

### Spacing
- **8px Grid System**: All spacing follows 8px increments
- **Consistent Margins**: Standardized spacing throughout

## 🔧 Available Scripts

- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run preview` - Preview production build
- `npm run lint` - Run ESLint
- `npm run format` - Format code with Prettier

## 📱 Responsive Design

The application is fully responsive with breakpoints:
- **Mobile**: < 768px
- **Tablet**: 768px - 1024px  
- **Desktop**: > 1024px

## 🎯 Key Features Explained

### Rating System
- **Posing**: Evaluate the subject's pose and positioning
- **Style**: Rate the overall style and fashion sense
- **Creativity**: Assess the creative elements and composition
- **Overall Impression**: Choose from Hot, Elegant, or Confident

### Social Scoring
Advanced algorithm that considers:
- Individual rating scores
- Number of ratings received
- Community engagement
- Photo quality metrics

### User Experience
- **Smooth Animations**: Framer Motion for fluid interactions
- **Instant Feedback**: Real-time updates and notifications
- **Intuitive Interface**: Clean, easy-to-understand design
- **Progressive Enhancement**: Works on all devices and browsers

## 🔒 Security Features

- **Input Validation**: Comprehensive form validation
- **File Upload Security**: File type and size validation
- **XSS Protection**: Sanitized user inputs
- **Authentication**: Secure user authentication flow

## 🚀 Performance Optimizations

- **Code Splitting**: Automatic route-based code splitting
- **Image Optimization**: Optimized image loading and display
- **Bundle Optimization**: Minimized bundle size
- **Caching**: Efficient caching strategies

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🙏 Acknowledgments

- **Pexels** for providing high-quality stock photos
- **Lucide React** for beautiful icons
- **Tailwind CSS** for the utility-first CSS framework
- **Framer Motion** for smooth animations