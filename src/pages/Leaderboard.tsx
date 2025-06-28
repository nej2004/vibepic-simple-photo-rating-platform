import React from 'react'
import { motion } from 'framer-motion'
import { Trophy, Medal, Award, TrendingUp } from 'lucide-react'

interface LeaderboardUser {
  id: number
  username: string
  profilePic: string
  socialScore: number
  totalPhotos: number
  avgRating: number
  rank: number
}

const Leaderboard = () => {
  const users: LeaderboardUser[] = [
    {
      id: 1,
      username: 'alexphoto',
      profilePic: 'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&w=100',
      socialScore: 2450,
      totalPhotos: 28,
      avgRating: 8.7,
      rank: 1,
    },
    {
      id: 2,
      username: 'fashionista',
      profilePic: 'https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&w=100',
      socialScore: 2380,
      totalPhotos: 32,
      avgRating: 8.5,
      rank: 2,
    },
    {
      id: 3,
      username: 'creativemind',
      profilePic: 'https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg?auto=compress&cs=tinysrgb&w=100',
      socialScore: 2290,
      totalPhotos: 25,
      avgRating: 8.9,
      rank: 3,
    },
    // Add more mock users...
    ...Array.from({ length: 20 }, (_, i) => ({
      id: i + 4,
      username: `user${i + 4}`,
      profilePic: `https://images.pexels.com/photos/${1000000 + i}/pexels-photo-${1000000 + i}.jpeg?auto=compress&cs=tinysrgb&w=100`,
      socialScore: 2200 - (i * 50),
      totalPhotos: Math.floor(Math.random() * 30) + 10,
      avgRating: Math.round((Math.random() * 3 + 6) * 10) / 10,
      rank: i + 4,
    })),
  ]

  const getRankIcon = (rank: number) => {
    switch (rank) {
      case 1:
        return <Trophy className="h-6 w-6 text-yellow-500" />
      case 2:
        return <Medal className="h-6 w-6 text-gray-400" />
      case 3:
        return <Award className="h-6 w-6 text-amber-600" />
      default:
        return <span className="text-lg font-bold text-gray-500">#{rank}</span>
    }
  }

  const getRankBadge = (rank: number) => {
    if (rank <= 3) {
      const colors = {
        1: 'bg-gradient-to-r from-yellow-400 to-yellow-600',
        2: 'bg-gradient-to-r from-gray-300 to-gray-500',
        3: 'bg-gradient-to-r from-amber-400 to-amber-600',
      }
      return colors[rank as keyof typeof colors]
    }
    return 'bg-gray-100'
  }

  return (
    <div className="min-h-screen bg-gray-50 py-8">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="text-center mb-8"
        >
          <h1 className="text-3xl font-bold text-gray-900 mb-2">Leaderboard</h1>
          <p className="text-gray-600">Top photographers and models in our community</p>
        </motion.div>

        {/* Top 3 Podium */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.1 }}
          className="grid md:grid-cols-3 gap-6 mb-12"
        >
          {users.slice(0, 3).map((user, index) => (
            <div
              key={user.id}
              className={`relative ${
                index === 0 ? 'md:order-2 md:scale-110' : index === 1 ? 'md:order-1' : 'md:order-3'
              }`}
            >
              <div className={`card text-center ${getRankBadge(user.rank)} ${user.rank <= 3 ? 'text-white' : ''}`}>
                <div className="relative inline-block mb-4">
                  <img
                    src={user.profilePic}
                    alt={user.username}
                    className="w-20 h-20 rounded-full object-cover mx-auto border-4 border-white shadow-lg"
                  />
                  <div className="absolute -top-2 -right-2">
                    {getRankIcon(user.rank)}
                  </div>
                </div>
                
                <h3 className="text-xl font-bold mb-2">{user.username}</h3>
                <div className="space-y-1 text-sm">
                  <p className="font-semibold text-lg">{user.socialScore.toLocaleString()} pts</p>
                  <p className="opacity-90">{user.totalPhotos} photos</p>
                  <p className="opacity-90">Avg: {user.avgRating}/10</p>
                </div>
              </div>
            </div>
          ))}
        </motion.div>

        {/* Full Leaderboard Table */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.2 }}
          className="card overflow-hidden"
        >
          <div className="px-6 py-4 border-b border-gray-200">
            <h2 className="text-xl font-semibold text-gray-900 flex items-center">
              <TrendingUp className="h-5 w-5 mr-2" />
              Full Rankings
            </h2>
          </div>
          
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead className="bg-gray-50">
                <tr>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Rank
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    User
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Social Score
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Photos
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Avg Rating
                  </th>
                </tr>
              </thead>
              <tbody className="bg-white divide-y divide-gray-200">
                {users.map((user, index) => (
                  <motion.tr
                    key={user.id}
                    initial={{ opacity: 0, x: -20 }}
                    animate={{ opacity: 1, x: 0 }}
                    transition={{ duration: 0.3, delay: index * 0.05 }}
                    className="hover:bg-gray-50 transition-colors"
                  >
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="flex items-center">
                        {user.rank <= 3 ? (
                          getRankIcon(user.rank)
                        ) : (
                          <span className="text-lg font-semibold text-gray-900">#{user.rank}</span>
                        )}
                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="flex items-center">
                        <img
                          src={user.profilePic}
                          alt={user.username}
                          className="w-10 h-10 rounded-full object-cover mr-3"
                        />
                        <div>
                          <div className="text-sm font-medium text-gray-900">{user.username}</div>
                        </div>
                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm font-semibold text-gray-900">
                        {user.socialScore.toLocaleString()}
                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-900">{user.totalPhotos}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-900">{user.avgRating}/10</div>
                    </td>
                  </motion.tr>
                ))}
              </tbody>
            </table>
          </div>
        </motion.div>
      </div>
    </div>
  )
}

export default Leaderboard