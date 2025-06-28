import React from 'react'
import { useParams } from 'react-router-dom'
import { motion } from 'framer-motion'
import { Camera, Star, Heart, Palette, Calendar, MapPin } from 'lucide-react'

const Profile = () => {
  const { id } = useParams()

  // Mock user data
  const user = {
    id: 1,
    username: 'alexphoto',
    email: 'alex@example.com',
    profilePic: 'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&w=400',
    bio: 'Professional photographer specializing in portrait and fashion photography. Always looking to improve and learn from the community.',
    location: 'New York, NY',
    joinDate: '2023-06-15',
    socialScore: 2450,
    totalPhotos: 28,
    totalRatings: 156,
    avgRatings: {
      posing: 8.7,
      style: 8.5,
      creativity: 8.9,
    },
  }

  const photos = [
    {
      id: 1,
      imageUrl: 'https://images.pexels.com/photos/1040880/pexels-photo-1040880.jpeg?auto=compress&cs=tinysrgb&w=400',
      caption: 'Golden hour portrait session',
      category: 'portrait',
      socialScore: 850,
      uploadDate: '2024-01-15',
    },
    {
      id: 2,
      imageUrl: 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=400',
      caption: 'Fashion editorial shoot',
      category: 'fashion',
      socialScore: 920,
      uploadDate: '2024-01-10',
    },
    {
      id: 3,
      imageUrl: 'https://images.pexels.com/photos/1181686/pexels-photo-1181686.jpeg?auto=compress&cs=tinysrgb&w=400',
      caption: 'Creative concept photography',
      category: 'concept',
      socialScore: 780,
      uploadDate: '2024-01-05',
    },
    // Add more mock photos...
    ...Array.from({ length: 9 }, (_, i) => ({
      id: i + 4,
      imageUrl: `https://images.pexels.com/photos/${1040880 + i}/pexels-photo-${1040880 + i}.jpeg?auto=compress&cs=tinysrgb&w=400`,
      caption: `Photo ${i + 4}`,
      category: ['portrait', 'fashion', 'concept'][i % 3],
      socialScore: Math.floor(Math.random() * 500) + 500,
      uploadDate: `2024-01-0${Math.floor(Math.random() * 9) + 1}`,
    })),
  ]

  const stats = [
    { label: 'Social Score', value: user.socialScore.toLocaleString(), icon: Star },
    { label: 'Photos', value: user.totalPhotos, icon: Camera },
    { label: 'Ratings Given', value: user.totalRatings, icon: Heart },
  ]

  return (
    <div className="min-h-screen bg-gray-50 py-8">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Profile Header */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="card mb-8"
        >
          <div className="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
            <img
              src={user.profilePic}
              alt={user.username}
              className="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg"
            />
            
            <div className="flex-1">
              <h1 className="text-3xl font-bold text-gray-900 mb-2">{user.username}</h1>
              
              <div className="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
                <div className="flex items-center">
                  <MapPin className="h-4 w-4 mr-1" />
                  {user.location}
                </div>
                <div className="flex items-center">
                  <Calendar className="h-4 w-4 mr-1" />
                  Joined {new Date(user.joinDate).toLocaleDateString()}
                </div>
              </div>
              
              <p className="text-gray-700 mb-4 max-w-2xl">{user.bio}</p>
              
              <div className="grid grid-cols-3 gap-4">
                {stats.map((stat) => (
                  <div key={stat.label} className="text-center">
                    <div className="flex items-center justify-center mb-1">
                      <stat.icon className="h-4 w-4 text-primary-600 mr-1" />
                      <span className="text-2xl font-bold text-gray-900">{stat.value}</span>
                    </div>
                    <div className="text-sm text-gray-600">{stat.label}</div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </motion.div>

        {/* Average Ratings */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.1 }}
          className="card mb-8"
        >
          <h2 className="text-xl font-semibold text-gray-900 mb-4">Average Ratings</h2>
          
          <div className="grid md:grid-cols-3 gap-6">
            <div className="text-center">
              <div className="flex items-center justify-center mb-2">
                <Heart className="h-5 w-5 text-red-500 mr-2" />
                <span className="text-lg font-semibold">Posing</span>
              </div>
              <div className="text-3xl font-bold text-gray-900 mb-2">{user.avgRatings.posing}</div>
              <div className="w-full bg-gray-200 rounded-full h-2">
                <div
                  className="bg-red-500 h-2 rounded-full"
                  style={{ width: `${(user.avgRatings.posing / 10) * 100}%` }}
                />
              </div>
            </div>
            
            <div className="text-center">
              <div className="flex items-center justify-center mb-2">
                <Star className="h-5 w-5 text-blue-500 mr-2" />
                <span className="text-lg font-semibold">Style</span>
              </div>
              <div className="text-3xl font-bold text-gray-900 mb-2">{user.avgRatings.style}</div>
              <div className="w-full bg-gray-200 rounded-full h-2">
                <div
                  className="bg-blue-500 h-2 rounded-full"
                  style={{ width: `${(user.avgRatings.style / 10) * 100}%` }}
                />
              </div>
            </div>
            
            <div className="text-center">
              <div className="flex items-center justify-center mb-2">
                <Palette className="h-5 w-5 text-green-500 mr-2" />
                <span className="text-lg font-semibold">Creativity</span>
              </div>
              <div className="text-3xl font-bold text-gray-900 mb-2">{user.avgRatings.creativity}</div>
              <div className="w-full bg-gray-200 rounded-full h-2">
                <div
                  className="bg-green-500 h-2 rounded-full"
                  style={{ width: `${(user.avgRatings.creativity / 10) * 100}%` }}
                />
              </div>
            </div>
          </div>
        </motion.div>

        {/* Photo Gallery */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.2 }}
        >
          <h2 className="text-2xl font-bold text-gray-900 mb-6">Photos ({photos.length})</h2>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {photos.map((photo, index) => (
              <motion.div
                key={photo.id}
                initial={{ opacity: 0, scale: 0.9 }}
                animate={{ opacity: 1, scale: 1 }}
                transition={{ duration: 0.3, delay: index * 0.1 }}
                className="photo-card group cursor-pointer"
              >
                <div className="aspect-w-1 aspect-h-1 mb-4">
                  <img
                    src={photo.imageUrl}
                    alt={photo.caption}
                    className="w-full h-64 object-cover rounded-lg group-hover:scale-105 transition-transform duration-300"
                  />
                </div>
                
                <div className="p-4">
                  <h3 className="font-semibold text-gray-900 mb-2">{photo.caption}</h3>
                  
                  <div className="flex items-center justify-between text-sm">
                    <span className="px-2 py-1 bg-primary-100 text-primary-800 rounded-full">
                      {photo.category}
                    </span>
                    <span className="text-gray-600">
                      Score: {photo.socialScore}
                    </span>
                  </div>
                  
                  <div className="text-xs text-gray-500 mt-2">
                    {new Date(photo.uploadDate).toLocaleDateString()}
                  </div>
                </div>
              </motion.div>
            ))}
          </div>
        </motion.div>
      </div>
    </div>
  )
}

export default Profile